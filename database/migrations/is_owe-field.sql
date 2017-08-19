
ALTER TABLE faucets
  ADD COLUMN is_debt tinyint NOT NULL DEFAULT  0;
