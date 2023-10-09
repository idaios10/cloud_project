# Eshop
Eshop is a cloud microservices demo application. It consists of a 9-tier microservices application and is deployed in containers with Docker and docker-compose.

Architecture

Service	Description
Application Logic	Exposes an Apache HTTP server to serve the website. Written in PHP, is basically the frontend service.
Keyrock Identity Manager	Manages user data, adds user authentication and authorization via the Keyrock API.
Wilma PEP Proxy	Enforces access control for security purposes, a proxy to protect the other services.
Data Storage	A REST API service written in PHP that supports GET/POST/DELETE/PUT on movie and favorite data. Extends the pub/sub system, for user-specific alerts.
Orion Context Broker	A publish/subscribe service that manages movie subscriptions as context elements. Enables notifications when certain conditions are met.
MySQL	Used by Keyrock to store all the user related data.
MongoDB	Two instances in the architecture, one that serves backend functionalities for the DataStorage service and stores all the movie and favorite data. The other one for storing the Orion context elements data.
Mongo Express	(Optional for the execution of the application) A helpful tool that provides a GUI for data management of the MongoDB instances.
This application is a web-based movie app with 3 type of users(Admins, Users and Shop Owners). Every user depending his role has the ability to execute different services and operations. 
