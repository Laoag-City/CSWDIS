## TO-DO'S

### 1. New Client Record Page.
This page has a form with fields for:
(Client's Info)
1. First Name - text
2. Middle Name - text
3. Last Name - text
4. Name Suffix - dropdown
5. Phone Number - text
6. Address - text
7. Sex - dropdown or radio button
8. Age - number
9. Date of Birth - date
{Client's Record Info}
10. Service Requested - dropdown
11. Users Permitted for Access - arrayed checkbox (only showed if chosen service requested is confidential)
12. Date Requested - date
13. Problem Presented - textarea
14. Initial Assessment - textarea
15. Recommendation - textarea
16. Action Taken - textarea
17. Action Taken Date - date

Note: For admin users, the service requested field will also contain services that are confidential. When the admin user chooses a confidential service, a table that lists other admin users with a checkbox for each will appear. Tick the checkbox for users who will have access to the record.

### 2. Client List Page.
This page has a GET request form with first name, middle name, last name, and name suffix fields which acts as parameters for searching a specific client.
Below the form is a table of clients with a dropdown for each record with options for View Client Info, Edit Client Info, Remove (admins only). The table is paginated for every 50 rows. When the form above is submitted, list only in the table the search result of the form. 

### 3. Client Info Page.
This page shows the info of a client and lists all of record infos (along with each record's history) of the client. Note that confidential records are only viewable by users allowed to access it. Each records listed will have options for Edit Record, Remove (admins only).

### 4. Edit Client Info Page
This page is for a specific client and has an edit form for the columns in the clients table.

### 5. Edit Client Record Page
This page is for a specific record and has an edit form for the columns in the records table.

## Admin Only Pages

### 6. User Management Dashboard
CRUD functionality for users.

### 7. Service Management Dashboard
CRUD functionality for services and its categories.
