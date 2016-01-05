CREATE DATABASE zapateria;

CREATE TABLE color (
	colorid INTEGER PRIMARY KEY NOT NULL,
	title VARCHAR(200) NOT NULL,
	view_type INTEGER DEFAULT '0', -- 0 - not view, 1 view
	PRIMARY KEY (colorid)
);

CREATE TABLE sizes (
	sizesid INTEGER PRIMARY KEY NOT NULL,
	size DECIMAL(2,1) NOT NULL,
	PRIMARY KEY (sizesid)
);

CREATE TABLE model (
	modelid INTEGER PRIMARY KEY NOT NULL,
	title VARCHAR(9) NOT NULL,
	view_type INTEGER DEFAULT '0', -- 0 - not view, 1 view
	PRIMARY KEY (modelid)
);

CREATE TABLE shoe (
	shoeid INTEGER PRIMARY KEY NOT NULL,
	price DECIMAL(5,2) NOT NULL,
	counter_type INTEGER DEFAULT '0', -- 0 - empaquetado, 1 - en mostrador
	colorid INTEGER NOT NULL,
	sizesid INTEGER NOT NULL,
	modelid INTEGER NOT NULL,
	PRIMARY KEY(shoeid),
	FOREIGN KEY (colorid) REFERENCES color(colorid),
	FOREIGN KEY (sizesid) REFERENCES sizes(sizesid),
	FOREIGN KEY (modelid) REFERENCES model(modelid)
);

CREATE TABLE branch (
	branchid INTEGER PRIMARY KEY NOT NULL,
	name VARCHAR(200) NOT NULL,
	address VARCHAR(200) NOT NULL,
	employeeid INTEGER NOT NULL,
	PRIMARY KEY (branchid),
	FOREIGN KEY (employeeid) REFERENCES employee(employeeid)
);

CREATE TABLE detail_stock (
	stockid INTEGER PRIMARY KEY NOT NULL,
	branchid INTEGER NOT NULL,
	shoeid INTEGER NOT NULL,
	--exist INTEGER,
	date_stock_up TIMESTAMP NOT NULL,
	date_stock_down TIMESTAMP NOT NULL,
	status_send INTEGER DEFAULT 0, -- 0 - sin movimiento, 1 - enviado, 2 - recibido
	PRIMARY KEY (stockid),
	FOREIGN KEY (branchid) REFERENCES branch(branchid),
	FOREIGN KEY (shoeid) REFERENCES shoe(shoeid)
);

CREATE TABLE sale (
	saleid INTEGER PRIMARY KEY NOT NULL,
	date_sale TIMESTAMP NOT NULL,
	employeeid INTEGER NOT NULL,
	clientid INTEGER NOT NULL,
	PRIMARY KEY (saleid),
	FOREIGN KEY (employeeid) REFERENCES employee(employeeid),
	FOREIGN KEY (clientid) REFERENCES client(clientid)
);

CREATE TABLE detail_sale (
	detail_sale_id INTEGER PRIMARY KEY NOT NULL,
	saleid INTEGER NOT NULL,
	stockid INTEGER NOT NULL,
	PRIMARY KEY (detail_sale_id),
	FOREIGN KEY (saleid) REFERENCES sale(saleid),
	FOREIGN KEY (stockid) REFERENCES detail_stock(stockid)
);

CREATE TABLE client (
	clientid INTEGER PRIMARY KEY NOT NULL,
	firstname VARCHAR(200) NOT NULL,
	lastname VARCHAR(200) NOT NULL,
	mat_name VARCHAR(200) NOT NULL,
	email VARCHAR(200) NOT NULL,
	phone VARCHAR(10) NOT NULL,
	PRIMARY KEY (clientid)
);

CREATE TABLE employee (
	employeeid INTEGER PRIMARY KEY NOT NULL,
	firstname VARCHAR(200) NOT NULL,
	lastname VARCHAR(200) NOT NULL,
	mat_name VARCHAR(200) NOT NULL,
	email VARCHAR(200) NOT NULL,
	phone VARCHAR(10) NOT NULL,
	address VARCHAR(200) NOT NULL,
	type_employee INTEGER DEFAULT '0', -- 0 - vendedor, 1 - gerente, 2 - director
	PRIMARY KEY (employeeid)
);

CREATE TABLE user_credentials (
   email VARCHAR(200) NOT NULL,
   password VARCHAR(40) NOT NULL,
   employeeid INTEGER NOT NULL,
   PRIMARY KEY (email),
   FOREIGN KEY (employeeid) REFERENCES employee(employeeid)
);

CREATE TABLE order_shoe (
	orderid INTEGER PRIMARY KEY NOT NULL,
	date_order TIMESTAMP NOT NULL,
	date_delivery TIMESTAMP NOT NULL,
	status INTEGER NOT NULL, -- 0 - en espera, 1 - procesando, 2 - finalizado, 3 - demorado, 4 - entregado
	description VARCHAR(500) NOT NULL,
	clientid INTEGER NOT NULL,
	shoeid INTEGER NOT NULL,
	PRIMARY KEY (orderid),
	FOREIGN KEY (shoeid) REFERENCES shoe(shoeid),
	FOREIGN KEY (clientid) REFERENCES client(clientid)
);

CREATE TABLE transition_shoe_log(
	
);

CREATE TABLE sale_list_tmp(

);