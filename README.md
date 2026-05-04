# OpenBiblio

Open source library management system.

## Docker Installation

```bash
cp .env.example .env   # edit passwords and TZ as needed
docker compose up -d
```

The install wizard runs automatically. Once complete the app is available at `http://localhost:8080`.

Default admin credentials: **admin** / **Administrator#1**

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

### Notes

- The upload form for USMARC import (`/catalog/upload_usmarc_form.php`) defaults to **test mode** — records are previewed but not saved. Switch the radio button to "Import" to actually insert records.
