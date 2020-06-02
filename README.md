# lbaw2012

## Theme 3 - Online Shop
Our goal is to give a new and better option to plant lovers, to give them a platform where they can buy and obtain more information regarding the plants they love the most, as well as recommend new plants that might be to their liking. 

### 1. Docker commands
To test our docker image use this command, you first have to build it with the command:

`docker build -t <IMAGE_NAME>`.

Then run it with:

`docker-compose up && docker run --net lbaw2012_default --link lbaw2012_default -it -p 8000:80 <IMAGE_NAME>`

### 2. Usage

The project can be accessed through this [link](http://lbaw2012.lbaw-prod.fe.up.pt).  

#### 2.1. Administration Credentials

| Email | Password |
| -------- | -------- |
| root@root.com    | rootroot |

#### 2.2. User Credentials

| Type          | Email  | Password |
| ------------- | --------- | -------- |
| customer | john@doe.com    | johndoe |

### Team

* Ana Loureiro, up201705749@fe.up.pt
* André Rocha, up201706462@fe.up.pt
* Filipe Ferreira, up201706086@fe.up.pt
* João Silva Martins, up201707311@fe.up.pt

***
GROUP2012, 02/05/2020