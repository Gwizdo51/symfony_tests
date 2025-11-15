-- READ

SELECT * FROM dbo.client;
SELECT * FROM dbo.company;

--DELETE FROM dbo.company;
--INSERT INTO dbo.company (name, address) VALUES
--('FCN', 'Bezannes'),
--('Airbus', 'Toulouse'),
--('Apple', 'Silicon Valley');

--DELETE FROM dbo.client;
--INSERT INTO dbo.client (name, email, company_id) VALUES
--('Arthur', 'a.clement@fcn.fr', 3),
--('John', 'j.aziz@fcn.fr', 3),
--('Fred', 'f.lddlld@airbus.fr', 4);

-- CTRL + SHIFT + Q
--SELECT company.*, client.*
--FROM     client RIGHT OUTER JOIN
--                  company ON client.company_id = company.id
