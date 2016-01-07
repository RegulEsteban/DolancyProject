CREATE DATABASE zapateria;

CREATE TABLE color (
	colorid INT PRIMARY KEY NOT NULL,
	title VARCHAR(200) NOT NULL,
	view_type INT DEFAULT '0', -- 0 - not view, 1 view
	PRIMARY KEY (colorid)
);

CREATE TABLE sizes (
	sizesid INT PRIMARY KEY NOT NULL,
	size DECIMAL(2,1) NOT NULL,
	PRIMARY KEY (sizesid)
);

CREATE TABLE model (
	modelid INT PRIMARY KEY NOT NULL,
	title VARCHAR(9) NOT NULL,
	view_type INT DEFAULT '0', -- 0 - not view, 1 view
	PRIMARY KEY (modelid)
);

CREATE TABLE shoe (
	shoeid INT PRIMARY KEY NOT NULL,
	price DECIMAL(5,2) NOT NULL,
	counter_type INT DEFAULT '0', -- 0 - empaquetado, 1 - en mostrador
	colorid INT NOT NULL,
	sizesid INT NOT NULL,
	modelid INT NOT NULL,
	PRIMARY KEY(shoeid),
	FOREIGN KEY (colorid) REFERENCES color(colorid),
	FOREIGN KEY (sizesid) REFERENCES sizes(sizesid),
	FOREIGN KEY (modelid) REFERENCES model(modelid)
);

CREATE TABLE branch (
	branchid INT PRIMARY KEY NOT NULL,
	name VARCHAR(200) NOT NULL,
	address VARCHAR(200) NOT NULL,
	employeeid INT NOT NULL,
	PRIMARY KEY (branchid),
	FOREIGN KEY (employeeid) REFERENCES employee(employeeid)
);

CREATE TABLE detail_stock (
	stockid INT PRIMARY KEY NOT NULL,
	branchid INT NOT NULL,
	shoeid INT NOT NULL,
	--exist INT,
	date_stock_up TIMESTAMP NOT NULL,
	date_stock_down TIMESTAMP NOT NULL,
	--status_send INT DEFAULT 0, -- 0 - sin movimiento, 1 - enviado, 2 - recibido
	PRIMARY KEY (stockid),
	FOREIGN KEY (branchid) REFERENCES branch(branchid),
	FOREIGN KEY (shoeid) REFERENCES shoe(shoeid)
);

CREATE TABLE sale (
	saleid INT PRIMARY KEY NOT NULL,
	date_sale TIMESTAMP NOT NULL,
	employeeid INT NOT NULL,
	client_opid INT,
	status INT NOT NULL DEFAULT 0, -- 0 - sin confirmar, 1 - confirmada
	total DECIMAL(9,2) NOT NULL,
	PRIMARY KEY (saleid),
	FOREIGN KEY (employeeid) REFERENCES employee(employeeid)
);

CREATE TABLE detail_sale (
	detail_sale_id INT PRIMARY KEY NOT NULL,
	saleid INT NOT NULL,
	stockid INT NOT NULL,
	PRIMARY KEY (detail_sale_id),
	FOREIGN KEY (saleid) REFERENCES sale(saleid),
	FOREIGN KEY (stockid) REFERENCES detail_stock(stockid)
);

CREATE TABLE client (
	clientid INT PRIMARY KEY NOT NULL,
	firstname VARCHAR(200) NOT NULL,
	lastname VARCHAR(200) NOT NULL,
	matname VARCHAR(200) NOT NULL,
	email VARCHAR(200) NOT NULL,
	phone VARCHAR(10) NOT NULL,
	PRIMARY KEY (clientid)
);

CREATE TABLE employee (
	employeeid INT PRIMARY KEY NOT NULL,
	firstname VARCHAR(200) NOT NULL,
	lastname VARCHAR(200) NOT NULL,
	matname VARCHAR(200) NOT NULL,
	email VARCHAR(200) NOT NULL,
	phone VARCHAR(10) NOT NULL,
	address VARCHAR(200) NOT NULL,
	type_employee INT DEFAULT '0', -- 0 - vendedor, 1 - gerente, 2 - director
	PRIMARY KEY (employeeid)
);

CREATE TABLE user_credentials (
   email VARCHAR(200) NOT NULL,
   password VARCHAR(40) NOT NULL,
   employeeid INT NOT NULL,
   status INT DEFAULT 0, -- 0 - activado, 1 - desactivado
   PRIMARY KEY (email),
   FOREIGN KEY (employeeid) REFERENCES employee(employeeid)
);

CREATE TABLE order_shoe (
	orderid INT PRIMARY KEY NOT NULL,
	date_order TIMESTAMP NOT NULL,
	date_delivery TIMESTAMP NOT NULL,
	status INT NOT NULL, -- 0 - en espera, 1 - procesando, 2 - finalizado, 3 - demorado, 4 - entregado
	description VARCHAR(500) NOT NULL,
	clientid INT NOT NULL,
	shoeid INT NOT NULL,
	employeeid INT NOT NULL,
	PRIMARY KEY (orderid),
	FOREIGN KEY (shoeid) REFERENCES shoe(shoeid),
	FOREIGN KEY (clientid) REFERENCES client(clientid),
	FOREIGN KEY (employeeid) REFERENCES employee(employeeid)
);

CREATE TABLE transition_shoe_log(
	transitionid INT PRIMARY KEY NOT NULL,
	branch_destination_id INT NOT NULL,
	stockid INT NOT NULL,
	date_transition_up TIMESTAMP NOT NULL,
	date_transition_down TIMESTAMP NOT NULL,
	employeeid INT NOT NULL,
	PRIMARY KEY (transitionid),
	FOREIGN KEY (stockid) REFERENCES detail_stock(stockid),
	FOREIGN KEY (employeeid) REFERENCES employee(employeeid),
	FOREIGN KEY (branch_destination_id) REFERENCES branch(branchid)
);

CREATE TABLE cash_discount(
	discountid INT PRIMARY KEY NOT NULL,
	porcentage INT NULL,
	monto DECIMAL(9,2) NULL,
	description VARCHAR(200) NULL,
	PRIMARY KEY (discountid)
);

CREATE TABLE detail_discount(
	detail_discountid INT PRIMARY KEY NOT NULL,
	discountid INT NOT NULL,
	saleid INT NULL,
	detail_sale_id INT NULL,
	date_discount TIMESTAMP NOT NULL,
	FOREIGN KEY (discountid) REFERENCES cash_discount(discountid)
);