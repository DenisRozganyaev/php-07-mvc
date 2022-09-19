ALTER TABLE posts ADD CONSTRAINT category_fk FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL;
