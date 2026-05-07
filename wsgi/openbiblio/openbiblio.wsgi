#!openbiblio_venv/bin/python
import sys
import os

# Set the Python path to include your application's directory
sys.path.insert(0, '/home/openbiblio/htdocs/wsgi/openbiblio')

# Import your WSGI application object
# Replace 'your_flask_app' with the name of your Flask application instance
# For example, if your Flask app is named 'app' in 'wsgi.py', use 'app'
# If you have a Django project, this might look different (e.g., import your_project.wsgi)
# For this example, let's assume you have a file named 'wsgi_app.py' with a Flask app instance named 'app'
from openbiblio import app as application

if __name__ == "__main__":
    # This part is for development testing, not for Apache
    # You would typically use a development server like Flask's built-in one
    # or a production WSGI server like Gunicorn/uWSGI for production deployments.
    from wsgiref.simple_server import make_server

    httpd = make_server('', 8000, application)
    print("Serving on port 8000...")
    httpd.serve_forever()

