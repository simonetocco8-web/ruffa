# Blueprint

Interfaccia web responsive per la gestione di uno studio di fisioterapia, realizzata in PHP e predisposta per MySQL 8.

## Avvio della demo

```bash
php -S 127.0.0.1:8080
```

Aprire `http://127.0.0.1:8080`. Tutti i moduli sono navigabili e l'agenda include il flusso di creazione appuntamento. I dati mostrati nell'interfaccia sono dimostrativi.

## Database

Creare lo schema con:

```bash
mysql -u root -p < database/schema.sql
```

La connessione PDO legge `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`. Lo schema include pazienti e cartelle cliniche, allegati, agenda, prestazioni, fatture, pagamenti ripartiti su più conti, prima nota, utenti e configurazione dello studio. Il trigger `payment_split_to_ledger` riporta automaticamente ogni quota di pagamento in prima nota.
