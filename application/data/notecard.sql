CREATE TABLE notecard (
    id INTEGER PRIMARY KEY,
    text TEXT,
    project_id INTEGER
);

INSERT INTO notecard VALUES (
    null,
    'Hi there, here''s a notecard',
    1
);
