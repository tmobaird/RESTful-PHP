# RESTful
This is the code for my RESTful coral shop application. My coral shop is located at http://ec2-54-174-106-89.compute-1.amazonaws.com/
There is no interface or anything on this page, this application simply GETs, PUTs, or DELETEs data through manipulation of the URL or through curl requests. The URL can only be manipulated to utilize the GET function. An example of this would be entered in the URL bar as: 
http://ec2-54-174-106-89.compute-1.amazonaws.com/corals/
This url would display the list of all corals, and their listed price, in the database. The following URL GET request:
http://ec2-54-174-106-89.compute-1.amazonaws.com/corals/testCoral
Would search the database for all coral with the name testCoral.
Curl requests (from command line) can also be made on the web application. Curl requests for GET, PUT, and DELETE would be entered as follows:

 GET
------
curl http://ec2-54-174-106-89.compute-1.amazonaws.com/corals/testCoral

 PUT (requres name of the coral and price)
------
curl -X PUT http://ec2-54-174-106-89.compute-1.amazonaws.com/corals/testCoral -d 'price'='$59.00'

 DELETE (would delete testCoral from the database)
--------
curl -X DELETE http://ec2-54-174-106-89.compute-1.amazonaws.com/corals/testCoral
