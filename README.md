# mvc-api-example
Please note this is not production-ready code as it has been extracted from a Docker container I developed. Some features may not work or may not compile, this is just an example of how I developed it. 


-   API Authorization implemented on Back + Front end (Login System)
-   Added "API" versioning
-   V1  `does not allow Authorization`  and uses "MVC" pattern
-   V2  `allows Authorization`  and uses leverages a  [Repository Design Pattern](https://cubettech.com/resources/blog/introduction-to-repository-design-pattern/)
-   Database Migration + Seeder

### Layout

-   As usual the API routes are defined in  `routes/api`
-   Authentication is at  `http/controllers/api/UserController`
-   V1 model files are:  `http/controllers/api/GetUnitsController`,  `http/controllers/api/ToggleUnitsController`, uses HTTP Codes from  `Http/Code`  and uses the models  `Unit, UnitCharge`
-   V2 - files are in  `Repositories`  -  `Providers, Interface and Class.`

## Database architecture

-   I developed the database in a very simple way. If this were to be a production build then this database should not be used as it would be harder to maintain!
