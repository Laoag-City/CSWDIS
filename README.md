## CSWD Information System

A Laravel/Vue.js web application for the City Social Welfare Development Office. It manages the records of the CSWD, specifically confidential client records like women/child abuse, family problems, and other socially related issues.

**Features:**

1.  Adding of Client Record. When the service given to the client is classified as a confidential service, then only a CSWD user account with confidential accessor rights have the ability to input the record. For non-confidential services, a regular CSWD user account would suffice.
2. A confidential accessor account can only access the records it saved. It cannot access other confidential records made by other accounts. This is so to ensure that who handled the client's concerns is the only one to have access to.
3. History logs of every user actions.
4. Statistic handling of every male, female, and total clients per month with an option to download it as Excel file.
