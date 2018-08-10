<!DOCTYPE html>
<html lang="it-IT">
<head>
<title>Launch Template</title>
<meta charset="utf-8">
<?php

if ($_GET['f']=='md'){
	$bold="return '**'+s+'**'";
}else{
	$bold="if (s.substr(0,1)=='(') s=' '+s
return '[b]'+s+'[/b]'";
}

$tz= date('T'); //Timezone locale

print "
<script>
pads={

'Baikonur':['SLC 1/5','SLC 31/6','SCL 81/24','SLC 200/39'],
'Cape Canveral AFS':['SLC 37','SLC 40','SLC 41'],
'Jiuquan SLC':[],
'KSC':['SLC 39A','SCL 39B'],
'Kourou':['ELA-3','ZLS','ZLV'],
'Mahia':['LC 1'],
'Plesetsk':[],
'Satish Dhawan SC (Sriharikota)':[],
'Taiyuan SLC':[],
'Tanegashima Space Center':[],
'Vandenberg AFB':['SLC 2W','SLC 3E','SLC 4E','SLC 6','SLC 8','SLC 576-E'],
'Vostochny':[],
'Xichang SLC':[],
'Wenchang SLC':[]

}

var numpay=0


function addev(){
	var s=document.getElementById('spaceports')
	for (var p in pads){
		var tmp = new Option(p);
        s.options.add(tmp);
	}

	var f=document.forms[0]
	for (var i=0;i<f.elements.length;i++){
		if (f.elements[i].classList!=null){
			if (f.elements[i].classList.contains('show')){
				f.elements[i].setAttribute('onkeyup','update('+i+')')
			}
			if (f.elements[i].classList.contains('uncheck')){
				f.elements[i].checked=false;
			}
		}
	}

	update()
}

function aggiungi(id){
	var dum=document.getElementById('p_0').innerHTML
	if (numpay==0){
		dum=dum.replace('*Payload','*Payload (1)')
		document.getElementById('p_0').innerHTML=dum;
	}
	numpay++
	var np = document.createElement('div');
	np.setAttribute('id','p_'+numpay)
	dum=dum.replace('*Payload (1)','*Payload ('+(numpay+1)+')')
	np.innerHTML=dum
	var dum=document.getElementById('payload')
	dum.appendChild(np)
	update()
}

function bold(s){
$bold
}

function changeSel(sel1,sel2id,avoptions) {
    var sel2 = document.getElementById(sel2id);
    var selsel1 = sel1.options[sel1.selectedIndex].value;

    while (sel2.options.length>1) {
        sel2.remove(sel2.options.length-1);
    }
    sel2.onchange()

    var opt = avoptions[selsel1];
    if (opt) {
        for (var i = 0; i < opt.length; i++) {
            var tmp = new Option(opt[i]);
            sel2.options.add(tmp);
        }
    }
}

function datetimecomp(dcid,duid,ocid,ouid,df){
	dc=document.getElementById(dcid).value
	du=document.getElementById(duid).value
	oc=document.getElementById(ocid).value
	ou=document.getElementById(ouid).value

	if (df=='utc'){ // completa CET con UTC
		if (du!=''){
			if (ou!=''){
				var d=new Date(du+'T'+ou)
				d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
				dc= formatdate(d)
				document.getElementById(dcid).value=dc
				oc= formattime(d)
				document.getElementById(ocid).value=oc
				update()
			}
		}
	}else{ // Completa UTC con CET
		if (dc!=''){
			if (oc!=''){
				var d=new Date(dc+'T'+oc)
				d.setMinutes(d.getMinutes() + d.getTimezoneOffset());
				du=formatdate(d)
				document.getElementById(duid).value=du
				ou=formattime(d)
				document.getElementById(ouid).value=ou
				update()
			}
		}
	}
}

function formatdate(d){
	return d.getFullYear()+'-'+((d.getMonth()+1)+100).toString().substr(1,2)+'-'+((d.getDate())+100).toString().substr(1,2);
}
function formattime(d){
	return ((d.getHours())+100).toString().substr(1,2)+':'+((d.getMinutes())+100).toString().substr(1,2)+':'+((d.getSeconds())+100).toString().substr(1,2);
}

function insertselected(s){
	var f=document.forms[0]
	for (var i=0;i<f.elements.length;i++){
		if (f.elements[i]==s){
			if(s.selectedIndex>0)
				f.elements[i+1].value=s.value
			else
				f.elements[i+1].value=''
			update()
			break
		}
	}
}

function rimuovi(id){
	if (numpay>0){
 		var dum = document.getElementById('payload');
  		dum.removeChild(dum.lastChild);
		numpay--
		if (numpay==0){
			var dum=document.getElementById('p_0').innerHTML
			dum=dum.replace('*Payload (1)','*Payload')
			document.getElementById('p_0').innerHTML=dum;
		}
		update()
	}
}

function toggle(d){
	stato=document.getElementById(d.name).style.display;
	if (stato=='none')
		document.getElementById(d.name).style.display='block';
	else
		document.getElementById(d.name).style.display='none';
	update()
}

function update(i){
	var ret=''
	var f=document.forms[0];

	for (var i=0;i<f.elements.length;i++){
		if (f.elements[i].classList!=null){

			if (f.elements[i].classList.contains('show')){
				e=f.elements[i]

				//Elementi che hanno un nome
				if (e.name!=null){
					var name=e.name
					var pref='', suff=' '
					if (name.charAt(0)=='*'){
						pref+='\\n'
						var name=e.name.substr(1)
					}else if (name.charAt(0)=='-'){
						pref+='- '
						var name=e.name.substr(1)
					}else if (name.charAt(0)=='/'){
						pref+='/ '
						var name=e.name.substr(1)
					}
					if (f.elements[i].classList.contains('finestra')){
						if (e.value!=''){
							var fic=document.getElementById('datac').value+'T'+document.getElementById('oraic').value
							var d=new Date(fic)
							d.setMinutes(d.getMinutes()+parseInt(e.value))
							var ffc=formatdate(d)+'T'+formattime(d)

							var fiu=document.getElementById('datau').value+'T'+document.getElementById('oraiu').value
							var d=new Date(fiu)
							d.setMinutes(d.getMinutes()+parseInt(e.value))
							var ffu=formatdate(d)+'T'+formattime(d)
							suff=' minuti ($tz: '+fic+' - '+ffc+' / UTC: '+fiu+' - '+ffu+')'
						}
					}

					var mostra=false;
					if (f.elements[i].classList.contains('ifnotempty')){
						if ((e.value!='')){
							mostra=true
						}
					}else if(f.elements[i].classList.contains('spacex')){
						if (document.getElementById('spacex').style.display=='block'){
							mostra=true
						}
					}else{
						mostra=true;
					}
					if (mostra==true){
						ret+= pref + ((name!='')?bold(name)+': ':'')
						ret+=e.value + suff
					}

				}
			}
		}
	}
	document.getElementById('out').innerHTML=ret;
}
</script>
</head>
<body onload='addev()'><form>

<b>Data ($tz):</b> <input type='text' id='datac' name='Data ($tz)' class='show' placeholder='AAAA-MM-GG' onchange=\"datetimecomp('datac','datau','oraic','oraiu','cet')\">
<b>(UTC):</b> <input type='text' id='datau' name='/(UTC)' class='show' placeholder='AAAA-MM-GG' onchange=\"datetimecomp('datac','datau','oraic','oraiu','utc')\">
<br><br>

<b>Ora ($tz):</b> <input type='text' id='oraic' name='*Ora ($tz)' class='show' placeholder='HH:MM:SS' onchange=\"datetimecomp('datac','datau','oraic','oraiu','cet')\">
<b>(UTC):</b> <input type='text' id='oraiu' name='/(UTC)' class='show' placeholder='HH:MM:SS' onchange=\"datetimecomp('datac','datau','oraic','oraiu','utc')\">
<br><br>

<b>Finestra:</b> <input type='text' name='*Finestra' class='show ifnotempty finestra' placeholder='Durata in minuti'>
<br><br>

<b>Zona di lancio:
<select id='spaceports' onchange=\"insertselected(this);changeSel(this,'pad',pads)\"><option>Selezionare</option></select>
<input type='text' name='*Zona di lancio' class='show' placeholder='Nome spazioporto'>
- <select id='pad' onchange='insertselected(this)'><option>Selezionare</option></select>
<input type='text' name='-' class='show' placeholder='Numero pad'>
<br><br>

<b>Lanciatore:</b> <input type='text' name='*Lanciatore' class='show' placeholder='Nome e configurazione'>
<input type='text' name='/Upperstage' class='show ifnotempty' placeholder='Nome upperstage'>
<br><br>

<div style='border-left: 3px solid grey;padding-left:4px'><input type='checkbox' name='spacex' class='uncheck' onclick='toggle(this)'> SpaceX
<br>
<div id='spacex' style='display:none'>
<br>
<b>Core:</b> <input type='text' name='*Core' class='show spacex' placeholder='Identificativo core'>
<br><br>

<b>Static fire ($tz): </b>
<input type='text' id='sfdc' name='*Static Fire ($tz)' class='show spacex' placeholder='AAAA-MM-GG' onchange=\"datetimecomp('sfdc','sfdu','sfoc','sfou','cet')\">
<input type='text' id='sfoc' name='' class='show spacex' placeholder='HH:MM:SS' onchange=\"datetimecomp('sfdc','sfdu','sfoc','sfou','cet')\">
<b>(UTC): </b>
<input type='text' id='sfdu' name='/(UTC)' class='show spacex' placeholder='AAAA-MM-GG' onchange=\"datetimecomp('sfdc','sfdu','sfoc','sfou','utc')\">
<input type='text' id='sfou' name='' class='show spacex' placeholder='HH:MM:SS' onchange=\"datetimecomp('sfdc','sfdu','sfoc','sfou','utc')\">
<br><br>

<b>Recupero core:</b><input type='text' name='*Recupero Core' class='show spacex' placeholder='Nome LZ o droneship'>
<br><br>

<b>Recupero fairing:</b><input type='text' name='*Recupero fairing' class='show spacex' placeholder='Nome natante'>
</div></div>
<br>

<div style='border-left: 3px solid grey;padding-left:4px'><div id='payload'><div id='p_0'>
<b>Payload:</b> <input type='text' name='*Payload' class='show' placeholder='Nome payload'>
<b>Committente:</b> <input type='text' name='Committente' class='show' placeholder='Nome committente'>
<b>Massa:</b><input type='text' name='Massa' class='show' placeholder='Kg al lancio'>
<b>BUS:</b><input type='text' name='BUS' class='show ifnotempty' placeholder='Nome piattaforma'>
</div></div>
<br>
<input type='button' value='Aggiungi' onclick=\"aggiungi('payload')\">
<input type='button' value='Rimuovi' onclick=\"rimuovi('payload')\"></div>

<br>
<b>Altri payload:</b> <input type='text' name='*Altri payload' class='show ifnotempty' placeholder='numero mini/micro/nanosatelliti'>
<br><br>

<b>Orbita di inserimento:</b>
<select onchange='insertselected(this)'><option>Selezionare</option><option>LEO</option><option>SSO</option><option>MEO</option><option>GTO</option></select>
<input type='text' name='*Orbita di inserimento' class='show' placeholder='Tipo di orbita'> <input type='text' name='' class='show idnotempty' placeholder='Parametri orbitali'>
<br><br>

<b>Destinazione:</b> <input type='text' name='*Destinazione' class='show ifnotempty' placeholder='Destinazione finale del lancio'>
<br><br>

<textarea id='out' style='width:100%;height:500px;'></textarea>
</form>";

?>
</body></html>
