#!openbiblio_venv/bin/python

import base64
from bottle import Bottle, run, request
import cgi
import cv2
from isbnlib import is_isbn10, is_isbn13
import isbnlib
import json
import logging
import numpy as np
from pyzbar.pyzbar import decode
import sys
import tempfile
import _io

logging.basicConfig(stream=sys.stderr, level=logging.INFO)
logging.getLogger().setLevel(logging.INFO)

app = Bottle()

logging.info("WSGI Application 'openbiblio': started")

def test_isbn_service(serv):
    try:
        isbnlib.meta("9783161484100",service=serv)
        return True
    except:
        return False

isbn_services = [ s for s in [ "goob", "wiki", "openl", "dnb", "loc" ] if test_isbn_service(s) ]

logging.info(f"WSGI Application 'openbiblio': remaining isbn_services{isbn_services}")

@app.route('/hello')
def hello():
    return "Hello World!"


@app.route('/isbn_from_picture', method='POST')
def isbn_from_picture():
    result = {
        "success": False, 
        "data": []
    }

    logging.info(f"ISBN_FROM_PICTURE (request.body): {request.body}")
    if isinstance(request.body, tempfile._TemporaryFileWrapper):
        with open(request.body.name, 'r') as tmpf:
            fdata = tmpf.read()
            if fdata.startswith("data:image/png;base64,"):
                logging.info(f"data: {fdata[0:64]}")
                nparr = np.asarray(
                    bytearray(base64.b64decode(fdata[22:])), dtype="uint8")
            else:
                raise ValueError("Unsupprted input data in request body")
    elif isinstance(request.body, _io.BytesIO):
        fdata = request.body.read()
        if fdata.startswith(b"data:image/png;base64,"):
            logging.info(f"data: {fdata[0:64]}")
            nparr = np.asarray(
                bytearray(base64.b64decode(fdata[22:])), dtype="uint8")
        else:
            raise ValueError("Unsupprted input data in request body")
    else:
        raise ValueError("unsupported data type in fetch request")
    
    logging.info(f"{nparr[0:64]}")
    
    img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

    barcodes = decode(gray)
    logging.debug(f"Barcodes: {barcodes}")
    isbn_barcodes = [code for code in barcodes if is_isbn13(
        code.data.decode('utf-8')) or is_isbn10(code.data.decode('utf-8'))]
    logging.debug(f"ISBN Barcodes: {isbn_barcodes}")

    if len(barcodes) == 0:
        cv2.putText(img, "NO BARCODES", (20, 20),
                    cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 0, 255), 2)
    else:
        for barcode in isbn_barcodes:
            # Extract barcode data and type
            barcode_data = barcode.data.decode("utf-8")
            result["data"].append({"type": barcode.type, "data": barcode_data})
            # Print barcode data and type
            logging.info(
                f"Barcode found Type: {barcode.type}, Data: {barcode_data}")
            (x, y, w, h) = barcode.rect
            cv2.rectangle(img, (x, y), (x + w, y + h), (0, 255, 0), 4)
            # Put barcode data and type on the image
            cv2.putText(img, f"{barcode_data} ({barcode.type})",
                        (x, y), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 2)

    (success, img_encode) = cv2.imencode('.png', img)
    if success:
        result["success"] = True
        data_encode = bytearray(img_encode)
        byte_encode = base64.b64encode(data_encode).decode('utf-8')
        result["image"] = byte_encode
    logging.info(f"isbn_fom_picture=>Success={result['success']}: Data={result['data']}")
    return json.dumps(result)


@app.route('/metadata_from_isbn', method='GET')
def metadata_from_isbn():
    result = {
        "success": True,
        "data": []
    }
    ilist = request.query.get('isbnlist').split(',')
    logging.info(f"called with {json.dumps(ilist)}")
    isbnlist = [c for c in ilist if is_isbn13(c) or is_isbn10(c)]
    for isbn in isbnlist:
        entry = {"isbn": isbn, "metadata": []}
        for serv in isbn_services:
            try:
                mdata = isbnlib.meta(isbn, service=serv)
                entry["metadata"].append({"service": serv, "data": mdata})
            except:
                logging.warn(
                    f"failure resolving metadata for isbn {isbn} on service {serv}")
        try:
            entry["classifier"] = isbnlib.classify(isbn)
        except:
            logging.warn(f"No classification for isbn {isbn}")
        try:
            entry["description"] = isbnlib.desc(isbn)
        except:
            logging.warn(f"No description for isbn {isbn}")
        try:
            entry["coverURL"] = isbnlib.cover(isbn)
        except:
            logging.warn(f"No cover URL for isbn {isbn}")
        result["data"].append(entry)
    return json.dumps(result)


if __name__ == '__main__':
    print(f"ARGC: {len(sys.argv)}")
    if len(sys.argv) > 1:
        run(host='localhost', port=8080, debug=True)
    else:
        print("CGI invoked")
