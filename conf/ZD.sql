select * from shoe;

select ds.*, sum(s.price) from detail_stock ds
join shoe s on s.shoeid = ds.shoeid
group by (ds.stockid), rollup(s.price);