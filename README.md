# Hotel Triage System Setup + Admin/Patient Perspectives

### NOTE: THIS ASSIGNMENT WAS DONE BASED OFF THE ORIGINAL DESCRIPTION OF A4 RELEASED ON BRIGHTSPACE.

### How to setup application
- **Step 1**:Ensure PostgreSQL and pgAdmin4 are installed on your system.
- **Step 2**: Connect to PostgreSQL Server
Add a New Server: If you haven't already connected to your PostgreSQL server, you need to add a new server.

Click on the "Servers" item in the Browser panel on the left.
Right-click and select Create > Server....
In the "Create - Server" dialog, fill in the following details:
General tab:
Name: Enter a name for your server connection (e.g., Localhost).
Connection tab:
Host name/address: localhost (or the IP address of your PostgreSQL server).
Port: 5432 (default PostgreSQL port).
Maintenance database: postgres.
Username: postgres (or your PostgreSQL username).
Password: Enter your PostgreSQL password.
Save and Connect: Click Save to connect to the server.


- **Step 3**: Create a New Database
Navigate to Databases: In the Browser panel, expand the server you just connected to and locate the Databases item.

Create a Database:

Right-click on Databases and select Create > Database....
In the "Create - Database" dialog, fill in the following details:
Database: Enter hospitaltriage as the database name.
Owner: Select the owner of the database (default is the connected user, usually postgres).
Save: Click Save to create the new database.
![image](https://github.com/user-attachments/assets/e747fadd-105c-43d0-b5a8-f2b78e9b0f31)


Open the Query Tool:

Right-click on the newly created hospitaltriage database in the Object Browser.
Select "Query Tool" to open a new query editor window.
Execute the SQL Commands:(you can get this code under the database folder of assignment4)

1. -- Table for storing patient information

CREATE TABLE patients (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    uniquecode VARCHAR(5) NOT NULL UNIQUE,
    severity INT CHECK(severity BETWEEN 1 AND 10),
    arrival_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    treated BOOLEAN DEFAULT FALSE
);

2. -- Table for storing admin information

CREATE TABLE admins (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

- **Step 4**:Insert Test Data (Optional):

INSERT INTO patients (name, uniquecode, severity) VALUES 
('John', '234', 5),
('Jane', '678', 7),
('Alice', '101', 3);

 you can also insert the patient data on the webpage by adding patient :
 ![image](https://github.com/user-attachments/assets/8b4a75bc-af26-462c-af32-8f084abd26ef)

 INSERT INTO admins (username, password) VALUES ('admin', 'admin');

 you can also insert the admin by admin register on the webpage: 
![image](https://github.com/user-attachments/assets/729cbbcb-a5a2-4485-be99-1f7aabe7231a)
 


- **Step 5**: Enter the corresponding PostgreSQL username and password that you cloned from the repo on your computer, found in under folder server/db_connect.php
![image](https://github.com/user-attachments/assets/a813314b-b476-4fd1-b3ea-af748667dd3d)

## Additional Notes:

make sure IN PHP.init file that you find in your computer under C:\Program Files\php-8.3.9(might be different on your PC, mines php-8.3.9) make sure these extensions are enabled by removing “;”
extension=pdo_pgsql
extension=pgsql
![image](https://github.com/user-attachments/assets/66d075ab-341f-40cc-b25b-f95b64c64b4c)

## How To Run:
1. Clone the repository
2. Download all the dependencies
3. Setup server + db
4. Run the server
5. Open the browser and go to localhost:3000

## Features:
- Admin's can register and login
- Users can login/logout
- Admin has separate view of dashboard

## User Perspective:
- User can login 
- Provide the 3-letter code to view approximate wait time

## Admin Perspective:
- Admin can register and login
- View admin panel with patient info including name, code, severity, and date arrive in the queue
- if the patient is treated, it will not show any information about this patient, if check his waiting time after treated, it will print below message:
- ![image](https://github.com/user-attachments/assets/382f238e-5bdf-4214-bd74-2f5a1389e6fe)

## mage page: 
- click check patient list: displays a list of patients with their IDs, severity levels, and wait times in a hospital triage system.
![image](https://github.com/user-attachments/assets/8f800095-eef1-42c7-8479-815ab02272d7)
 
  
- time table: if the first patient is being treated, the second patient wait time will update. also wait time table will show the postion of current patient is based on the arrival time and severity.
![image](https://github.com/user-attachments/assets/a4233433-df40-4c49-945d-8e44b5077cb5)




