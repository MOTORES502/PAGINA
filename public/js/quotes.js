var cmoneda="";

function formatEI(num){
    var p = num.toFixed(2).split(".");
    return cmoneda+" " + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];

}

function num_f(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
function get_rate(PR, IN, PE) {
	var PAY = (PR * IN) / (1 - Math.pow(1 + IN, -PE))
	return PAY
}
function auto_format_field(fid){
	var pre_c=num_f($(fid).val(),0);
	var cnum=pre_c.replace(/\D+/g, '');
	if(cnum!=""){
		//console.log("cnum ini:"+cnum);
		var lchars=parseInt(cnum);
		//console.log("input lchars:"+lchars);
		var out_chars=formatEI(lchars);
		$(fid).val(out_chars);
	}
}
function calcularCuotas(moneda,precio){
	cmoneda=moneda;
	document.getElementById("o_trace").innerHTML="Procesando...";
	var engancheInput=$("#inputEnganche").val();
	
	var enganche=0;
	enganche = (engancheInput + '').replace(/[^0-9+\-Ee.]/g, '');
	var enganche_min=(precio/100)*20;
	if(enganche<enganche_min){
		enganche=enganche_min;
	}
	$("#inputEnganche").val(enganche);
	auto_format_field("#inputEnganche");
	var mesCombo=document.getElementById("mes_c");
	var indice=mesCombo.selectedIndex;
	var meses=mesCombo.options[indice].value;
	var precioMenos=precio-enganche;
	var enganche_q=0;
	var interest = 0.15;
	
	if(moneda=="$"){
		enganche_q=enganche*8;
	}else{
		enganche_q=enganche;
	}
	
	var monthly_payment=get_rate(precioMenos,interest/12,meses);
	
	var cuota=num_f(monthly_payment);
	var cuotaSeguro=num_f(((precio/100)*5)/12);
	document.getElementById("cuotasDesdeResult").innerHTML="<span class=\"resaltado_a-NA\">Cuota: "+moneda+num_f(monthly_payment)+"</span><br />*No incluye seguro";

	document.getElementById("o_trace").innerHTML="*Seguro aproximado: "+moneda+cuotaSeguro+" mensual<br />*Cuota aproximada de financiamiento";
}

function calcularCuotas_d(moneda,precio){
	cmoneda=moneda;
	document.getElementById("o_trace_d").innerHTML="Procesando...";
	var engancheInput=$("#inputEnganche_d").val();
	var enganche=0;
	enganche = (engancheInput + '').replace(/[^0-9+\-Ee.]/g, '');
	var enganche_min=(precio/100)*20;
	if(enganche<enganche_min){
		enganche=enganche_min;
	}
	$("#inputEnganche_d").val(enganche);
	auto_format_field("#inputEnganche_d");
	var mesCombo=document.getElementById("mes_c_d");
	var indice=mesCombo.selectedIndex;
	var meses=mesCombo.options[indice].value;
	var precioMenos=precio-enganche;
	var enganche_q=0;
	var interest = 0.15;

	if(moneda=="$"){
		enganche_q=enganche*8;
	}else{
		enganche_q=enganche;
	}
	if(enganche_q<=40000){
		interest=0.17;
	}else{
		interest=0.15;
	}

	
	var monthly_payment=get_rate(precioMenos,interest/12,meses);
	
	var cuota=num_f(monthly_payment);
	var cuotaSeguro=num_f(((precio/100)*5)/12);
	document.getElementById("cuotasDesdeResult_d").innerHTML=moneda+num_f(monthly_payment)+"<br /><span style=\"font-size:14px;\">*No incluye seguro</span>";

	document.getElementById("o_trace_d").innerHTML="*Seguro aproximado: "+moneda+cuotaSeguro+" mensual<br />*Cuota aproximada de financiamiento";
}