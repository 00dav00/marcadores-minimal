select 
 t.tor_id
,t.tor_nombre
,t.tor_anio_referencia
,t.tor_fecha_inicio
,t.tor_fecha_fin
,t.tor_tipo_equipos

,tt.ttr_id
,tt.ttr_nombre

,f.fas_id
,f.fas_descripcion

,tf.tfa_id
,tf.tfa_nombre

,fe.fec_id
,fe.fec_numero
,fe.fec_fecha_referencia

from torneos as t
join tipo_torneos as tt on t.ttr_id = tt.ttr_id
join fases as f on t.tor_id = f.tor_id
join tipo_fases as tf on tf.tfa_id = f.tfa_id
join fechas as fe on f.fas_id = fe.fas_id 


