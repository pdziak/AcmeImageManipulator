# AcmeImageManipulator

Test task

## Requirements
- Docker
- Composer

## Instalation

- Clone the repo https://github.com/pdziak/AcmeImageManipulator.git
- In terminal in the project root path run: **docker-compose up --build**
- Go to **www** directory.
- In terminal in the above path run: **composer install**

## Usage

- Example URL of use: **http://localhost:38080/chinese-house.jpg/crop-800,1000,800,600**
  Where:
    * chinese-house.jpg is the image filename
    * crop- is the modifier name
    * 800,1000,800,600 - modifier params

So for example above you will pick chinese-house.jpg, crop it starting from 800 and 1000 and using size 800x600

## Adding images

There is one image bundled with this package. You can add your images to **www/uploads**
then use the image name as a parameter, eg. http://localhost:38080/your-image-name.jpg/crop-800,1000,800,600

## Futher releases

Add support for multiple modifiers, eg:
http://localhost:38080/chinese-house.jpg/crop-800,1000,800,600|resize-800,600