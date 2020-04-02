
# Elastic Stack with Docker (PHP sample App)

Simple PHP Application using Elastic Stack running with Docker.

## **ELK Stack** consists of : 

- ***Elasticsearch*** : for data storage (working on port 9200).

- ***Logstash*** : forwarding data to the elasticsearch (working on port 9600).

- ***Filebeat*** : for data collection.

- ***Kibana*** : visualise graphs and dashboards (works on port 5601).

## Setting up the environment :

- ``docker-compose up -d ``  to initialize all the needed services.

- ```cd app && composer install```  to install needed PHP dependencies.

- ```php app/app.php -a foo -b bar```  to execute the PHP sample application and generate logs.
