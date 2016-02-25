select shoe.price, m.title As ss, c.title, z.size, ds.discountid
from detail_sale ds
join detail_stock s on ds.stockid = s.stockid
join shoe on s.shoeid = shoe.shoeid
join model m on m.modelid = shoe.modelid
join sizes z on z.sizesid = shoe.sizesid
join color c on c.colorid = shoe.colorid
--join cash_discount cd on cd.discountid = ds.discountid
where ds.saleid = 4;

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

select * from detail_sale;

select t.date_transition_down, t.date_transition_up, concat(eo.firstname,' ',eo.lastname,' ',eo.matname) as employee_order,
concat(bo.name,' ',bo.address) as branch_origin, concat(bd.name,' ',bd.address) as branch_destination, m.title as model,
c.title as color, sz.size, s.stockid
from transition_shoe_log t
join employee eo on t.employeeid_order = eo.employeeid
join branch bo on t.branch_origin_id = bo.branchid 
join branch bd on t.branch_destination_id = bd.branchid
join detail_stock s on t.stockid = s.stockid
join shoe sh on s.shoeid = sh.shoeid
join model m on sh.modelid = m.modelid
join color c on sh.colorid = c.colorid
join sizes sz on sh.sizesid = sz.sizesid
where t.branch_destination_id = 1 
and t.employeeid_order = 1;

select u.status, concat(e.firstname,' ',e.lastname) as name,e.email,e.phone,e.address, e.type_employee 
from user_credentials u
join employee e on u.employeeid = e.employeeid;

select * from employee where employeeid not in (select employeeid from user_credentials);