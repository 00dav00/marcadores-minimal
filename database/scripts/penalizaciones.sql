select
p.fas_id,
f.fec_id,
p.eqp_id,
sum(ptr_puntos)   ptr_puntos
from penalizaciones_torneo p
join fases fa on p.fas_id = fa.fas_id
join (
  select fas_id,min(fec_id) fec_id
  from fechas group by fas_id
) f on f.fas_id = p.fas_id
where fa.tor_id = 1
group by
p.fas_id,
f.fec_id,
p.eqp_id;