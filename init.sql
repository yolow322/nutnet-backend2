CREATE TABLE USERS_FOR_GOOGLE_SHEETS (
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(35) NOT NULL,
    surname VARCHAR(35) NOT NULL,
    age INTEGER CHECK (age > 0 AND age <= 100) NOT NULL
);