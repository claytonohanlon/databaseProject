CREATE TABLE Market(
	Name VARCHAR(20) PRIMARY KEY,
    openTime VARCHAR(4),
    closeTime VARCHAR(4),
    volumeTradedPerDay INT(12)
);

CREATE TABLE Admin(
	adminID INT(8) PRIMARY KEY,
    adminUsername VARCHAR(20),
    adminPassword VARCHAR(20),
    lastLogOn VARCHAR(18)
);

CREATE TABLE Customer(
	customerID VARCHAR(13) PRIMARY KEY,
    balance DECIMAL(10,2),
    fName VARCHAR(20),
    mName VARCHAR(20),
    lName VARCHAR(20),
    customerUsername VARCHAR(16) UNIQUE,
    customerPassword VARCHAR(16)
);

CREATE TABLE CustomerBillingInfo(
	customerID VARCHAR(13) REFERENCES Customer(customerID),
    address VARCHAR(64),
    cardNumber VARCHAR(16),
	PRIMARY KEY(customerID,address,cardNumber)
);

CREATE TABLE CommonStock(
	tickerSymbol VARCHAR(4) PRIMARY KEY,
    sharePrice DECIMAL(4,2),
    companyName VARCHAR(20),
    totalShares INT(8),
    sharesAvailable INT(8),
    votePercentage INT(3)
);

CREATE TABLE PreferredStock(
	tickerSymbol VARCHAR(4) REFERENCES CommonStock(tickerSymbol),
    sharePrice DECIMAL(5,2),
    companyName VARCHAR(20),
    totalShares INT(8),
    sharesAvailable INT(8)
);

CREATE TABLE PortfolioContents(
	customerID VARCHAR(13) REFERENCES Customer(customerID),
    portfolioID VARCHAR(13) REFERENCES Portfolio(portfolioID),
    tickerSymbol VARCHAR(4) REFERENCES CommonStock(tickerSymbol),
    amount INT(4),
    PRIMARY KEY(customerID,portfolioID,tickerSymbol,amount)
);

CREATE TABLE Portfolio(
	customerID VARCHAR(13) REFERENCES Customer(customerID),
    portfolioID VARCHAR(13),
    netWorth DECIMAL(12,2),
    PRIMARY KEY(customerID,portfolioID)
);

CREATE TABLE testTable(
	testUsername VARCHAR(24),
    testPassword VARCHAR(24),
    PRIMARY KEY(testUsername,testPassword)
);

INSERT INTO Market VALUES('New York SE','800','1700',24951846);
INSERT INTO Market VALUES('London SE','830','1730',53246896);
INSERT INTO Market VALUES('NASDAQ','900','1600',56364864);
INSERT INTO Market VALUES('Frankfurt SE','800','1630',71314420);

INSERT INTO Admin VALUES(12345678,'clayton','maaaRk908','11/25/2016 1259');
INSERT INTO Admin VALUES(87654321,'ethan','badM0ND0','11/23/2016 433');
INSERT INTO Admin VALUES(44448888,'roger','bigguyBANE4u','11/25/2016 132');

INSERT INTO Customer VALUES(1,56.12,'Mark','James','Chang','mChang','jellyfish123');
INSERT INTO Customer VALUES(2,1234.98,'John','William','Smith','johnSMITH','yellow576');
INSERT INTO Customer VALUES(3,653234.10,'Donald','James','Trump','theDON','BUILDWALL1231');
INSERT INTO Customer VALUES(4,1.01,'Alex',NULL,'Tariah','alextariah','password');
INSERT INTO Customer VALUES(5,45.67,'Hanna','Gertrude','Holland','HHoland','123sparky321');
INSERT INTO Customer VALUES(6,980.45,'Sarah','Jane','Catron','sarahcat','iovecats678');
INSERT INTO Customer VALUES(7,9876.69,'Fred','Brady','Louis','freddlouiss','volleywally4545');

INSERT INTO CustomerBillingInfo VALUES(1,'434 Cleveland Dr Ames IA 50010',3582682902448576);
INSERT INTO CustomerBillingInfo VALUES(2,'9178 East Lafayette Lane Albany NY 12203',5214985324562458);
INSERT INTO CustomerBillingInfo VALUES(3,'66 Carpenter Ave Snohomish WA 98290',8273103487324532);
INSERT INTO CustomerBillingInfo VALUES(4,'951 Oak Meadow Rd Avon Lake OH 44012',4354657687986745);
INSERT INTO CustomerBillingInfo VALUES(5,'721 Lake St Boston MA 02127',1233245356547689);
INSERT INTO CustomerBillingInfo VALUES(6,'880 West Shore Court Horn Lake MS 38637',9854619535876591);
INSERT INTO CustomerBillingInfo VALUES(7,'7898 North Columbia Street Stellite Beach FL 32937',9875032300864267);

INSERT INTO CommonStock VALUES('GOML',82.13,'Gater Omlets',1000,402,5);
INSERT INTO CommonStock VALUES('TREE',10.89,'Toms Tree Houses',10000,1234,7);
INSERT INTO CommonStock VALUES('OGPZ',7.25,'Original Pizza',10000,6428,1);
INSERT INTO CommonStock VALUES('MTCG',50.12,'MT Climbing Gear',1000,104,10);

INSERT INTO PreferredStock VALUES('UUUU',444.37,'4U Movers',1000,12);
INSERT INTO PreferredStock VALUES('RNOS',2.82,'Rhino Sauces',10000,5432);
INSERT INTO PreferredStock VALUES('LADS',100.09,'Large Lad Outfits',10000,980);
INSERT INTO PreferredStock VALUES('DASD',266.34,'Daniels Sourdough',1000,632);

INSERT INTO PortfolioContents VALUES(1,30000001,'GOML',3);
INSERT INTO PortfolioContents VALUES(1,30000001,'TREE',4);
INSERT INTO PortfolioContents VALUES(1,30000001,'OGPZ',6);
INSERT INTO PortfolioContents VALUES(1,30000001,'MTCG',2);
INSERT INTO PortfolioContents VALUES(2,30000002,'UUUU',9);
INSERT INTO PortfolioContents VALUES(2,30000002,'RNOS',2);
INSERT INTO PortfolioContents VALUES(2,30000002,'LADS',1);
INSERT INTO PortfolioContents VALUES(3,30000003,'OGPZ',21);
INSERT INTO PortfolioContents VALUES(3,30000003,'MTCG',23);
INSERT INTO PortfolioContents VALUES(3,30000003,'LADS',16);
INSERT INTO PortfolioContents VALUES(4,30000004,'RNOS',1);
INSERT INTO PortfolioContents VALUES(5,30000005,'UUUU',1);
INSERT INTO PortfolioContents VALUES(5,30000005,'OGPZ',2);
INSERT INTO PortfolioContents VALUES(6,30000006,'GOML',4);
INSERT INTO PortfolioContents VALUES(6,30000006,'MTCG',3);
INSERT INTO PortfolioContents VALUES(7,30000007,'GOML',3);
INSERT INTO PortfolioContents VALUES(7,30000007,'LADS',2);
INSERT INTO PortfolioContents VALUES(7,30000007,'RNOS',4);

INSERT INTO Portfolio VALUES(1,30000001,433.69);
INSERT INTO Portfolio VALUES(2,30000002,4105.06);
INSERT INTO Portfolio VALUES(3,30000003,2906.45);
INSERT INTO Portfolio VALUES(4,30000004,2.82);
INSERT INTO Portfolio VALUES(5,30000005,458.87);
INSERT INTO Portfolio VALUES(6,30000006,478.88);
INSERT INTO Portfolio VALUES(7,30000007,457.85);
