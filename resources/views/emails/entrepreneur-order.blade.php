<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Nouvelle commande</title>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
</head>

<body bgcolor="#e0e0e0">
<table width="700" border="0" align="center" cellspacing="0" cellpadding="0">
	<tr>
    	<td bgcolor="#FFFFFF">
    		<table width="700" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="60" align="center" colspan="3" bgcolor="#f4912f" >BENOO ENERGIES - COMMANDE ENTREPRENEUR</td>
                </tr>
      			<tr>
        			<td width="30" height="50">&nbsp;</td>
        			<td>&nbsp;</td>
        			<td width="30">&nbsp;</td>
      			</tr>
      			<tr>
        			<td width="30">&nbsp;</td>
                    <td height="60">Bonjour, <br>
                        Une commande a été passée, voici les informations de l'entrepreneur :
                        <br><br>
                        <b>Prénom :</b> {{$entrepreneur->firstname}}<br>
                        <b>Nom :</b> {{$entrepreneur->lastname}}<br>
                        <b>Téléphone :</b> {{$entrepreneur->telephone}}
                        <br><br>
                        <b>Et voici les produits commandés :</b> <br>&nbsp;</td>
        			<td width="30">&nbsp;</td>
			  	</tr>
                  
      			<tr>
                    <td width="30">&nbsp;</td>
					<td>
                    <table border="1" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td bgcolor="#f4912f"><b>Produit</b></td>
                            <td bgcolor="#f4912f"><b>Quantité</b></td>
                            <td bgcolor="#f4912f"><b>Prix Unitaire</b></td>
                            <td bgcolor="#f4912f"><b>Prix Total</b></td>
                        </tr>
                        @foreach($products as $product)
                            @if($product != "" && !empty($product))
                            <tr>
                                <td>{{$product['title']}}</td>
                                <td>{{$product['qty']}}</td>
                                <td>{{$product['price']}}</td>
                                <td>{{$product['qty'] * $product['price']}}</td>
                            </tr>
                            @endif
                        @endforeach
						<tr>
                            <td colspan="3" bgcolor="#f4912f"><b>TOTAL : </b></td>
                            <td><b>{{$total}}</b> Fcfa</td>
                        </tr>
                    </table>						
					</td>

                    <td width="30">&nbsp;</td>
                </tr>
                <tr>
                  <td width="30" height="50">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td width="30">&nbsp;</td>
                </tr>

        </table>
    </td>
    
</table>

</body>
</html>

</tr>
