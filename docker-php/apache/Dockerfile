FROM httpd:latest

RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y nano vim curl git

RUN echo "" >> /usr/local/apache2/conf/httpd.conf && \
  echo "IncludeOptional /usr/local/apache2/conf/overwrite/httpd.conf" >> /usr/local/apache2/conf/httpd.conf && \
  echo "IncludeOptional /usr/local/apache2/conf/overwrite/sites-enabled/*.conf" >> /usr/local/apache2/conf/httpd.conf
