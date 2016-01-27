
ALTER TABLE faucets
  ADD COLUMN ban_until TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Datetime until fauces is banned.' AFTER priority;
