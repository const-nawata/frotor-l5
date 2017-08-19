
ALTER TABLE faucets
  ADD COLUMN is_owe tinyint NOT NULL DEFAULT  0;
