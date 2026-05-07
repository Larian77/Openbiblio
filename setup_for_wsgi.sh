#!/bin/bash

function fatal_error() {
	echo $1 >&2;
	exit 1;
}

function setup_python_env() {
	pushd wsgi/openbiblio || fatal_error "Cannot change to wsgi/openbiblio.";
	  python -m venv openbiblio_venv || fatal_error "Cannot prepare python virtual environment. Install module 'venv'?";
	  (
	    set -e
	    . openbiblio_venv/bin/activate;
	    pip install -r requirements.txt;
	    deactivate;
	  )
	popd; # wsgi/openbiblio
}

function prepare_apache_conf () {
  cat >OpenBiblio-apache2-tmpl.conf <<EOF_apache_conf
<IfModule mod_ssl.c>
<VirtualHost ${HOSTNAME}:443>
	ServerName ${HOSTNAME}
	ServerAdmin ${SERVER_ADMIN}

	DocumentRoot ${OPENBIBLIO_HTDOCS}

	ErrorLog \${APACHE_LOG_DIR}/openbiblio-error.log
	CustomLog \${APACHE_LOG_DIR}/openbiblio-access.log combined

	SSLEngine on
	SSLCertificateFile   ${OPENBIBLIO_CERTS}/${CERT_NAME}.crt.pem
	SSLCertificateKeyFile   ${OPENBIBLIO_CERTS}/${CERT_NAME}.key.pem
	SSLCertificateChainFile ${OPENBIBLIO_CERTS}/${CERT_NAME}.crt.pem

	<Directory ${OPENBIBLIO_HTDOCS}/>
   	  AllowOverride None
    	  Require all granted
	</Directory>

	<Directory ${OPENBIBLIO_CERTS}/>
   	  Require all denied
	</Directory>

        <IfModule mod_wsgi.c>
	  WSGIDaemonProcess openbiblio python-home=${OPENBIBLIO_HTDOCS}/wsgi/openbiblio/openbiblio_venv/
	  WSGIScriptAlias /wsgi/ ${OPENBIBLIO_HTDOCS}/wsgi/
        </IfModule>
        <IfModule mod_cgi.c>
	  ScriptAlias /cgi-bin/ ${OPENBIBLIO_HTDOCS}/wsgi/
        </IfModule>

	  <Directory ${OPENBIBLIO_HTDOCS}/wsgi/>
            AllowOverride None
        <IfModule mod_wsgi.c>
	    WSGIProcessGroup openbiblio
	    WSGIApplicationGroup %{GLOBAL}
        </IfModule>
        <IfModule mod_cgi.c>
            Options +ExecCGI
            AddHandler cgi-script .py
        </IfModule>
	    Require all granted
  	  </Directory>
        </IfModule>
</VirtualHost>
</IfModule>
# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
EOF_apache_conf
}

HOSTNAME=openbiblio.smolinski.name
SERVER_ADMIN=openbiblio@smolinski.name
OPENBIBLIO_HOME=/home/openbiblio
OPENBIBLIO_HTDOCS=${OPENBIBLIO_HOME}/htdocs
OPENBIBLIO_CERTS=${OPENBIBLIO_HOME}/certs
CERT_NAME=OpenBiblio-openbiblio.smolinski.name

setup_python_env;
prepare_apache_conf;
