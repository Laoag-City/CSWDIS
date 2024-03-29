## TO-DO'S

### After Cloning Repo
1. Make sure PHP Composer, NPM, Gulp, and XAMPP is installed.
2. Rename .env.example to .env
3. Run these commands in the project folder:
    composer install
    php artisan key:generate
    npm install
When prompted for inputs for Fomantic UI after inputting npm install, select Express as the installation mode, Yes when asked of project folder, public/semantic when asked where to place source files, dist/ folder when asked where to place compiled files, and leave the rest in its default selection.
4. Then cd to public/semantic folder and run this command to compile semantic
    gulp build
5. In the .env folder, set your development database values.
6. then go back to project folder and run this command to create the tables:
    php artisan migrate
7. All is set for development.

### 1. New Client Record Page.
This page has a form with fields for:
(Client's Info)
1. Name - text
2. Phone Number - text
3. Address - text
4. Sex - dropdown or radio button
5. Age - number
6. Date of Birth - date
{Client's Record Info}
7. Service Requested - dropdown
8. Users Permitted for Access - arrayed checkbox (only showed if chosen service requested is confidential)
9. Date Requested - date
10. Problem Presented - textarea
11. Initial Assessment - textarea
12. Recommendation - textarea
13. Action Taken - textarea
14. Action Taken Date - date

Note: For admin users, the service requested field will also contain services that are confidential. When the admin user chooses a confidential service, a table that lists other admin users with a checkbox for each will appear. Tick the checkbox for users who will have access to the record.

### 2. Client List Page.
This page has a GET request form with first name, middle name, last name, and name suffix fields which acts as parameters for searching a specific client.
Below the form is a table of clients with a dropdown for each record with options for View Client Info, Edit Client Info, Remove (admins only). The table is paginated for every 50 rows. When the form above is submitted, list only in the table the search result of the form. 

### 3. Client Info Page.
This page shows the info of a client and lists all of record infos (along with each client and record's history from the history table in database) of the client. Note that confidential records are only viewable by users allowed to access it. Each records listed will have options for Edit Record, Remove (admins only).

### 4. Edit Client Info Page
This page is for a specific client and has an edit form for the columns in the clients table.

### 5. Edit Client Record Page
This page is for a specific record and has an edit form for the columns in the records table.

## Admin Only Pages

### 6. User Management Dashboard
CRUD functionality for users.

### 7. Service Management Dashboard
CRUD functionality for services and its categories.
