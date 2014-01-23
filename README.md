# Resourcebag readme

## Uploading resource:
  POST /resources

## Listing all resources:
  GET /resources

## get info about a resource by id:
  GET /resources/52ca8d70a15ec01c0a1dd481

## search resources by filename
  GET /resources/search/odt

## Downloading a resource
  GET /resources/download/52ca8d70a15ec01c0a1dd481

## delete a resource by id
  DELETE /resources/52ca8d70a15ec01c0a1dd481


# Using curl to test the api:

## upload file
    curl -F file=@file-path http://localhost:3000/resources

## List all resources
    curl http://localhost:3000/resources

## get info about a resource by id
    curl http://localhost:3000/resources/52ca97b4245be51b0b3ebc2b

## search resource
    curl http://localhost:3000/search/txt

## downloading a resource
    curl http://localhost:3000/resources/download/52ca97b4245be51b0b3ebc2b

## deleting file
    curl -i -X DELETE http://localhost:3000/resources/52ca97b4245be51b0b3ebc2b
