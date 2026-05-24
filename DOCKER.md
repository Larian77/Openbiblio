# OpenBiblio

Open source library management system.

## Docker Installation

```bash
cp .env.example .env   # edit passwords and TZ as needed
docker compose up -d
```

If `INITIAL_ADMIN_PASSWORD` is set in `.env`, the install wizard runs automatically and the app is ready at `http://localhost:8989` once the stack is up. Admin username is **admin**; the password is whatever you set.

If `INITIAL_ADMIN_PASSWORD` is left blank, the automated install is skipped — open `http://localhost:8989/install/index.php` to run the wizard manually and choose your own admin password.

### Environment variables

| Variable | Default | Description |
|---|---|---|
| `TZ` | `UTC` | Timezone for PHP |
| `DB_NAME` | `openbiblio` | Database name |
| `DB_USER` | `db_user` | Database user |
| `DB_PASSWORD` | *(required)* | Database password |
| `MYSQL_ROOT_PASSWORD` | *(required)* | MariaDB root password |
| `DB_LOCALE` | `de` | UI locale (`de` or `en`) |
| `INSTALL_TEST_DATA` | `false` | Load sample data on install |
| `INITIAL_ADMIN_PASSWORD` | *(blank)* | Password for the initial `admin` account; leave blank to install manually via the web wizard |

### Notes

- The upload form for USMARC import (`/catalog/upload_usmarc_form.php`) defaults to **test mode** — records are previewed but not saved. Switch the radio button to "Import" to actually insert records.
