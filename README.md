## Codibly Tech Task

##### PHP 8.0 && Symfony 5.2 <3
This is an small example that PHP 8.0 doesn't have any `children fevers`.
The most problematic is migrating existing source code PHP < 7.4 to 8.0.
The complexity of migration is bigger when it contains a lot more of code.
Impossible is nothing.

### Requirements
Write applications using Symfony 4+
In which you will use the Messenger component to handle such tasks:
- product creation
- product edition
- downloading the list of products
- single product download
  Put these rest actions in a single controller, eg ProductController
  Use "messageBus" to extract logic from the controller and handle it according to the standards that Messenger enforces.
  The application does not have to have any interface, we do not need a docker, we are interested in the code of the Symphonic application itself.
  Write tests for warrants using phpunit.

### Overview by Codibly Interview
Great job guys! I was really, really surprised with the today's interview. After all I need to admit the level of it was very high. Definitely I still need to work harder. It was my pleasure to talk with you guys. No one's perfect. Answearing the questions is the hardest part. Remember, Scrum learns that the team has the highest value. Use it well.

Ps. There isn't any betters or worsters. Everybody who's reading it, it's nothing personal. If you don't get it, you should. Codibly have wonderfully shown that this code isn't a masterpiece. At least They have proven it perfectly.

Ps2. Just please stop Polish IT vs me. Codibly vs me is a fair challenge. Life is a journey isn't it?
#WorkHardDreamBig

### Example cURLs
##### POST
curl -X POST -v localhost:8080/api/product -d "name=productName" -d "price=123"

##### GET
curl -X GET -v localhost:8080/api/product/1

##### PUT
curl -X PUT -v localhost:8080/api/product/1 -d "name=newProductName" -d "price=321"

##### GET list
curl -X GET -v localhost:8080/api/products?name=productName

##### Running Unit Tests (inside container)
composer phpunit

###
###### Disclaimer
Copyright 2021 © All rights reserved by Luxurno Marcin Szostak. 
