select shoe.price, m.title As ss, c.title, z.size from detail_sale ds
join detail_stock s on ds.stockid = s.stockid
join shoe on s.shoeid = shoe.shoeid
join model m on m.modelid = shoe.modelid
join sizes z on z.sizesid = shoe.sizesid
join color c on c.colorid = shoe.colorid
where ds.saleid=1;

select shoe.price as price, m.title as model, c.title as color, z.size as size, b.name as branch_name, b.address as branch_address 
from detail_stock s
join shoe on s.shoeid = shoe.shoeid
join model m on m.modelid = shoe.modelid
join sizes z on z.sizesid = shoe.sizesid
join color c on c.colorid = shoe.colorid
join branch b on b.branchid = s.branchid
where m.modelid = 1 and z.sizesid = 1 and c.colorid = 1;

select * from employee e
join branch b on b.employeeid = e.employeeid
where e.employeeid = 1;