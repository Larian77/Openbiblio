<!--
SPDX-License-Identifier: GPL-3.0
SPDX-Copyright-Text: 2026 Holger Smolinski <holger@smolinski.name>
-->
<?php
 
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
?>
<style>
  .modal {
    position: fixed;
    top: 5%;
    left: 5%;
    width: 90%;
    height: 90%;
    background-color: rgb(117 190 218); /* fallback w/o transparncy */
    background-color: rgb(117 190 218 / 85%);
    display: none;
  }
  .modal-header {
   position: absolute;
   height: 1.5lh;
   width: 100%;
   top: 0%;
   left: 0%;
   background-color: rgb(117 190 218); /* fallback w/o transparncy */
  }
  .modal-close {
    color: white;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 50%;
    right: 0.5ex;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
  }	
  .modal-footer {
   position: absolute;
   height: 1.5lh;
   width: 100%;
   bottom: 0%;
   left: 0%;
   background-color: rgb(117 190 218); /* fallback w/o transparncy */
  }
  .modal-footer span {
    position: absolute;
    top: 50%;
    left: 50%;
    background-color: rgb(0 0 0);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
  }
  .modal-content {
  	position: absolute;
        width: 100%;
	height: calc(100% - 3lh); /* 3lh  = header.height + footer.height */
	top:1.5lh; /* header.height */
	left: 0%;
    overflow: auto;
  }

  #ISBNSelectorDiv {
    position: absolute;
    width: 100%;
    height: 15%;
    top:0%;
    left:0%;
    z-index: 10002;
    background-color: rgb(0 0 255);
  }
  #MetadataSelectorDiv {
    position: absolute;
    width: 15%;
    height: 85%; /* matches 100% - ISBNSelector.height */
    bottom: 0%;
    left: 0%;
    z-index: 10002;
    background-color: rgb(0 255 255);
  }
  #MetadataDisplayDiv {
    position: absolute;
    width: 85%; /* matches 100% - MetadataSelector.width */
    height: 85%; /* matches 100% - ISBNSelector.height */
    bottom: 0%;
    right: 0%;
    z-index: 10002;
    background-color: rgb(255 255 0);
  }

  #helper-div {
    display: flex;
  }
  #helper-div div {
    flex: 1;
    position: relative;
  }
  #capture-modal {
    display: none;
  }
  #capture-modal button {
    margin: 0;
    position: absolute;
    left: 50%;
    top: 50%;
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
  }
  #capture-video {
    display:none;
  }
  #video-preview {
    position:absolute;
    margin: 0;
    height: 100%;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    z-index: 2;
  }
  #capture-photo {
    display: none;
  }
  #photo-preview {
    display: none;
    position:absolute;
    margin: 0;
    height: 100%;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    z-index: 2;
  }
  #process-canvas {
    display: none;
  }
  #capture-button {
    display: none;
  }
  #start-button {
    display: none;
    z-index:3;
  }
  #stop-button {
    display: none;
    z-index:3;
  }
  #photo-form {
    position:absolute;
    margin: 0;
    height: 100%;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    z-index: 2;
  }

</style>

<div id="helper-div">
  <button id="scan-button">Scan</button>
  <div>
    <form id="photo-form" method="post" enctype="multipart/form-data">
      <label>Or select an image.
        <input id="filename-input" name="files" type="file" size="50" accept="text/*"> 
      </label>  
    </form>
  </div>
</div>

<div id="capture-modal" class="modal">
  <div class="modal-header">
       <span class="modal-close">X</span>
       <button id="stop-button">Stop camera access</button>
  </div>
  <div id="capture-div" class="modal-content">
    <video id="video-preview">No preview video to display.</video>
    <img id="photo-preview" src="" alt="A frame to display the captured photo." />
    <button id="start-button">Start camera access</button>
    <canvas id="process-canvas"><!-- hidden --></canvas>
    <video id="capture-video"><!-- hidden --></video>
    <img id="capture-photo"><!-- hidden --></img>
  </div>
  <div class="modal-footer">
    <button id="capture-button">Capture</button>
 </div>
</div>

<div id="ISBNSelectorModal" class="modal">
  <div id="ISBNSelectorModalHeader" class="modal-header">
    <span class="modal-close">X</span>
  </div>
  <div id="ISBNSelectorModalContent" class="modal-content">
    <div id="ISBNSelectorDiv"></div>
    <div id="MetadataSelectorDiv">ISBN lookup Service (click to select)</div>
    <div id="MetadataDisplayDiv"></div>
  </div>
  <div id="ISBNSelectorModalFooter" class="modal-footer"><span>Confirm</span></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
	let streaming = false;
	const urlBase=new URL(document.URL).origin;
        const canvas = document.getElementById("process-canvas");
        const captureButton = document.getElementById("capture-button");
        const captureModal = document.getElementById("capture-modal");
        const filenameInput = document.getElementById("filename-input");
        const isbnField = document.getElementsByName("values[020a]")[0]; // FIXME: I am not a unique name
        const titleField = document.getElementsByName("values[245a]")[0]; // FIXME: I am not a unique name
        const authorField = document.getElementsByName("values[100a]")[0]; // FIXME: I am not a unique name
	const isbnSelectorDiv= document.getElementById("ISBNSelectorDiv");
	const isbnSelectorModal = document.getElementById("ISBNSelectorModal");
	const isbnSelectorModalFooter = document.getElementById("ISBNSelectorModalFooter");
	const metadataDisplayDiv=document.getElementById("MetadataDisplayDiv");
	const metadataSelectorDiv=document.getElementById("MetadataSelectorDiv");
        const photo = document.getElementById("photo-preview");
        const scanButton = document.getElementById("scan-button");
        const startButton = document.getElementById("start-button");
        const stopButton = document.getElementById("stop-button");
        const video = document.getElementById("capture-video");
        const capturePhoto = document.getElementById("capture-photo");
        const videoPreview = document.getElementById("video-preview");

	const modalObserver = new MutationObserver( (mutations) => {
		    mutations.forEach(function(mutationRecord) {
			    console.log('style changed in:' + mutationRecord.target );
			    if (mutationRecord.target == captureModal) { // we observe attribute['style']
				    if ( captureModal.style.display == 'none') {
					    console.log('captureModal closed:'+captureModal.style.display);
				    } else {
					    console.log('display value:'+captureModal.style.display);
				    }
			    } else if (mutationRecord.target == photo) { // we observe attribute['src'] 
				    console.log('source changed:'+photo.src);
			    } else {
				    console.log("Stype change on unrgistered Modal" + mutationRecord.target);
			    }
		    });
	});
	
	const modalClosers = document.getElementsByClassName("modal-close"); // HTMLCollection
	
	Array.from(modalClosers).forEach( (span) => {
	  span.addEventListener( "click", (ev) => {
	    span.parentElement.parentElement.style.display = "none";
	  });
	});
	modalObserver.observe(captureModal, { attributes : true, attributeFilter : ['style'] });
	modalObserver.observe(photo, { attributes : true, attributeFilter : ['src'] });
	
	isbnSelectorModal.remove();
	document.body.appendChild(isbnSelectorModal);

	captureModal.remove();
	document.body.appendChild(captureModal);

	function clearElement(element) {
	    while (element.hasChildNodes()) {
	        element.removeChild(element.firstChild);
	    }
	}

	function clearPhoto() {
            const context = canvas.getContext("2d");
            context.fillStyle = "#aaaaaa";
            context.fillRect(0, 0, canvas.width, canvas.height);
            const data = canvas.toDataURL("image/png");
            photo.setAttribute("src", data);
	}
	
	function processPicture(data) {
	    return getISBNFromPicture(data)
		.then((json) => processIncomingISBN(json))
         	.catch((ex) => console.error(ex));
	}
	
	function previewPicture(url) {
            photo.setAttribute("src", url);
	    photo.style.display = 'block';
	}

	function prepareProcessCanvas(media, width, height) {
            const context = canvas.getContext("2d");
            context.drawImage(media, 0, 0, width, height);
	    const data = canvas.toDataURL("image/png");
	    return data;
	}

	function takeVideoPicture() {
	    canvas.width = video.width;
	    canvas.height = video.height;
	    data = prepareProcessCanvas(video,video.width, video.height);
	    pauseVideoCapture(5000);
            previewPicture(data);
	    processPicture(data);
	}

	function takeFilePicture(image) {
	    canvas.width = image.naturalWidth;
	    canvas.height = image.naturalHeight;
	    data = prepareProcessCanvas(image,image.naturalWidth, image.naturalHeight);
	    processPicture(data);
	}
	
	pictureProcessingTimeout = null;

	function pauseVideoCapture(milliseconds) {
		captureButton.style.display = 'none';
	        video.style.display = 'none';
                video.pause();
		pictureProcessingTimeout = setTimeout( function () {
		    resumeVideoCapture();
		}, milliseconds);
	}

	function resumeVideoCapture() {
		clearTimeout(pictureProcessingTimeout);
		captureButton.style.display = 'block';
                video.play();
	}

        function getISBNFromPicture(formdata) {
	    const url = new URL("/wsgi/openbiblio/openbiblio.wsgi/isbn_from_picture",urlBase);
            const params = {
                body: formdata,
                method: "POST"
	    };
	    return fetch(url, params)
		    .then((response) => response.json())
		    .then((json) => {
		    if (json.success) {
			    return json;
		     } else {
			     throw "Unsuccessful WSGI call (ISBN from picture)";
		     }
		     });
	}

	function getMetadataFromISBN(isbnlist) {
	    const url = new URL("/wsgi/openbiblio/openbiblio.wsgi/metadata_from_isbn",urlBase);
	    url.searchParams.set("isbnlist",isbnlist);
	    return fetch(url)
	        .then((response) => response.json())
		    .then((json) => {
		     if (json.success) {
			    return json.data;
		     } else {
			     throw "Unsuccessful WSGI call (Metadata from ISBN list)";
		     }
		     });
	}

	function createISBNSelectorBox(isbndatalist) {

	    let isbnSelectorBox= document.createElement("DIV");
	    
	    if (isbndatalist.length == 1) {
		let isbnSelectorItem = document.createElement("SPAN");
		isbnSelectorItem.appendChild(document.createTextNode(isbndatalist[0].isbn))
		isbnSelectorBox.appendChild(isbnSelectorItem);
	        updateMetadataSelectorDiv(isbndatalist[0]);
	    } else if (isbndatalist.length > 1) {
	        let isbnSelectorList = document.createElement("SELECT");
       	        isbnSelectorList.setAttribute("id","ISBNSelector");
		
		let option = document.createElement("OPTION");
		option.appendChild(document.createTextNode("Please select ISBN to process"));
		option.setAttribute("selected","1");
		isbnSelectorList.appendChild(option);			    

	        isbnSelectorList.addEventListener("change", (event) => {
	            console.log("ISBN selector Box changed selection to" + event.target.value);
		    isbndatalist.forEach((entry) => {
		        if (entry.isbn == event.target.value) {
			    updateMetadataSelectorDiv(entry);
		        }
		    });
		});

	        isbndatalist.forEach((entry) => {
	            let option = document.createElement("OPTION");
	            option.appendChild(document.createTextNode(entry.isbn));
	            isbnSelectorList.appendChild(option);			    
		});

		isbnSelectorBox.appendChild(isbnSelectorList);
	    } else {
		    throw "Empty isbndata";
	    }

	    return isbnSelectorBox;
	}

	function updateMetadataSelectorDiv(entry) {
		clearElement(metadataSelectorDiv);
		metadataSelectorDiv.appendChild(createMetadataSelectorBox(entry));
	}

	function createMetadataSelectorBox(isbnentry) {
		
	    let metadataSelectorBox= document.createElement("DIV");
	    
	    if (isbnentry.metadata.length == 1) {
		    metadataSelectorBox.appendChild(document.createTextNode(isbnentry.metadata[0].service));
		    updateMetadataDisplay(isbnentry,0);
	    } else if (isbnentry.metadata.length >= 1) {
		    let metadataSelectorList = document.createElement("UL");
		    isbnentry.metadata.forEach((entry,index) => {
		        let metadataSelectorListElement = document.createElement("LI");
		        metadataSelectorListElement.appendChild(document.createTextNode(entry.service));
		        metadataSelectorListElement.addEventListener("click", (event) => {
  			    updateMetadataDisplay(isbnentry,index);
		        });
		        metadataSelectorList.appendChild(metadataSelectorListElement);
		    });
		    metadataSelectorBox.appendChild(metadataSelectorList);
	    } else {
		    throw "empty metadata in isbn"+entry.isbn;
	    }

	    return metadataSelectorBox;

	}

	function createMetadataDisplay(entry,index) {
		let box = document.createElement("DIV");
		let heading = document.createElement("DIV");
		heading.appendChild(document.createTextNode("Service: "+entry.metadata[index].service));
		box.appendChild(heading);
		
		let body = document.createElement("DIV");
		let table = document.createElement("TABLE");
		let thead = document.createElement("THEAD");
		table.appendChild(thead);
		let rowth =document.createElement("TR");
		let col1 = document.createElement("TD");
		col1.appendChild(document.createTextNode("Field"));
		rowth.appendChild(col1);
		let col2 = document.createElement("TD");
		col2.appendChild(document.createTextNode("Value"));
		rowth.appendChild(col2);
		thead.appendChild(rowth);
		let tbody = document.createElement("TBODY");
		Object.keys(entry.metadata[index].data).forEach((key) => {
		   let row = document.createElement("TR");
                   let rowhead = document.createElement("TH");
		   rowhead.appendChild(document.createTextNode(key));
		   row.appendChild(rowhead);
		   let rowval = document.createElement("TD");
		   rowval.appendChild(document.createTextNode(entry.metadata[index].data[key]));
		   row.appendChild(rowval);
		   tbody.appendChild(row);
		});
		table.appendChild(tbody);
		body.appendChild(table);
		box.appendChild(body);

		let footer = document.createElement("DIV");
		footer.appendChild(document.createTextNode("Other Data"));
		box.appendChild(footer);
		return box;
	}

	function generateMetadataFields(entry,index) {
		console.log(JSON.stringify(entry));
		returnValue = {};
		returnValue["Authors"] = entry.metadata[index].data.Authors;
		returnValue["Title"] = entry.metadata[index].data.Title;
		console.log("RETURN:"+JSON.stringify(returnValue));
		return returnValue;
	}

	function updateMetadataDisplay(entry,index) {
		clearElement(metadataDisplayDiv);
		let selectedMetadata = generateMetadataFields(entry,index);
		console.log("METADATA:"+JSON.stringify(selectedMetadata));
		let transferSelectedMetadata = function () {
		    isbnSelectorModalFooter.removeEventListener("click", transferSelectedMetadata);
		    isbnSelectorModal.style.display = "none"; // TODO: Confirm and postprocess selection
		    titleField.setAttribute("value", selectedMetadata["Title"]);
		    authorField.setAttribute("value", selectedMetadata["Authors"]);
		}
		metadataDisplayDiv.appendChild(createMetadataDisplay(entry,index));
		isbnSelectorModalFooter.addEventListener("click", transferSelectedMetadata);
	}

	function displayISBNSelectionModal(isbndatalist) {

		clearElement(isbnSelectorDiv);
		clearElement(metadataSelectorDiv);
		clearElement(metadataDisplayDiv);

		isbnSelectorDiv.appendChild(createISBNSelectorBox(isbndatalist));
		isbnSelectorModal.style.display = "block";
		captureModal.style.display = "none";
	}

	function processIncomingISBN(json) {
                if (json.success) {
                    previewPicture("data:image/png;base64," + json.image);
		    if (json.data.length == 1) {
                        isbn = json.data[0];
                        console.log("Found ISBN " + JSON.stringify(isbn));
			isbnField.setAttribute("value", isbn.data);
			getMetadataFromISBN([ isbn.data ])
			    .then((isbndatalist) => { displayISBNSelectionModal(isbndatalist)});
                    } else if (json.data.length > 1) {
		        alert("More than one ISBN - NOT YET IMPLEMENTED " + json);
                    } else if (json.data.length == 0) {
		        console.log("No ISBN ISBN - NOT YET IMPLEMENTED " + json);
		    } else {
		        alert("Succesful: " + json);
		    }
		} else {
		    alert("Unsuccesful: " + json);
		}
        }


	function displayCaptureModal(element) {
	    captureModal.style.display = "block";
	    if (element !== photo) { photo.style.display = "none"; }
	    if (element !== videoPreview) { videoPreview.style.display = "none"; };
	    if (element) { element.style.display = "block"; }
	}

	filenameInput.addEventListener("change", (ev) => {
            const file = event.target.files[0];
	    displayCaptureModal(photo);
	    if (file.type.startsWith("image/")) {
		    const imgURL = URL.createObjectURL(file);
	    	    let photoLoadHandler = function () {
 	 	        photo.removeEventListener("load", photoLoadHandler);
		        takeFilePicture(photo);
	    	    }	
		    photo.addEventListener("load", photoLoadHandler);
		    photo.style.display="block";
		    photo.setAttribute("src", imgURL);
            } else {
                clearPhoto();
            }
	});

        video.addEventListener("canplay", (ev) => {
            if (!streaming) {
                let width = video.videoWidth / video.videoHeight * videoPreview.offsetHeight;
                videoPreview.setAttribute("width", width);
                video.setAttribute("width", video.videoWidth);
                video.setAttribute("height", video.videoHeight);
                canvas.setAttribute("width", video.videoWidth);
                canvas.setAttribute("height", video.videoHeight);
                streaming = true;
            } else {
                console.error("Video cannot play");
            }
        });

	function startVideoCapture() {
	    let constraints = {
                audio: false,
                video: {
                    facingMode: {
                        ideal: "environment"
                    },
                    frameRate: {
                        ideal: 5
                    },
                    resizeMode: "crop-and-scale",
                    width: {
                        ideal: 1520
                    }
                }
            };
            navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
                video.srcObject = stream;
                video.play();
                videoPreview.srcObject = stream;
                videoPreview.play();
                startButton.style.display = "none";
                stopButton.style.display = "block";
                captureButton.style.display = "block";
            }).catch((err) => {
                console.error(`An error occurred: ${err}`);
            });
	}
	
	scanButton.addEventListener("click", (ev) => { 
	  displayCaptureModal(null);
	  startVideoCapture();
          ev.preventDefault();
	});

        startButton.addEventListener("click", (ev) => {
  	  startVideoCapture();
          ev.preventDefault();
	});

        stopButton.addEventListener("click", (ev) => {
            video.pause();
            video.srcObject = null;
            videoPreview.pause();
            videoPreview.srcObject = null;
            streaming = false;
            stopButton.style.display = "none";
            startButton.style.display = "block";
            captureButton.style.display = "none";
            ev.preventDefault();
	});

        captureButton.addEventListener("click", (ev) => {
            takeVideoPicture();
            ev.preventDefault();
        });
    })
</script>
