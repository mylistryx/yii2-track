# create databases
CREATE DATABASE IF NOT EXISTS `yii2track`;
CREATE DATABASE IF NOT EXISTS `yii2track_test`;

# create root user and grant rights
CREATE USER IF NOT EXISTS 'root'@'localhost' IDENTIFIED BY 'verysecret';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';