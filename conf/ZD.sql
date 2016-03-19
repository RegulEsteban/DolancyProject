select transitionid, t.date_transition_down, employeeid_sender, 
    									t.date_transition_up, employeeid_transporter, employeeid_receiber,
    									concat(eo.firstname,' ',eo.lastname,' ',eo.matname) as employee_order, employeeid_order, 
    									concat(bo.name,' ',bo.address) as branch_origin, branch_origin_id,
    									concat(bd.name,' ',bd.address) as branch_destination, branch_destination_id,
    									m.title as model, c.title as color, sz.size, s.stockid
from transition_shoe_log t
				join employee eo on t.employeeid_order = eo.employeeid
				join branch bo on t.branch_origin_id = bo.branchid 
				join branch bd on t.branch_destination_id = bd.branchid
				join detail_stock s on t.stockid = s.stockid
				join shoe sh on s.shoeid = sh.shoeid
				join model m on sh.modelid = m.modelid
				join color c on sh.colorid = c.colorid
				join sizes sz on sh.sizesid = sz.sizesid;