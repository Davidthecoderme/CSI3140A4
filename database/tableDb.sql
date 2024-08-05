-- Table for storing patient information
CREATE TABLE patients (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    uniquecode VARCHAR(5) NOT NULL UNIQUE,
    severity INT CHECK(severity BETWEEN 1 AND 10),
    arrival_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    treated BOOLEAN DEFAULT FALSE
);

-- Table for storing admin information
CREATE TABLE admins (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
