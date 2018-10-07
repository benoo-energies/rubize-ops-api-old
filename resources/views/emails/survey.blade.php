<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Document sans nom</title>
</head>

<body bgcolor="#e0e0e0">
<table width="700" border="0" align="center" cellspacing="0" cellpadding="0">
	<tr>
    	<td bgcolor="#FFFFFF">
    		<table width="700" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="60" align="center" colspan="3" bgcolor="#f4912f" >BENOO ENERGIES - ENQUETE CLIENT</td>
                </tr>
      			<tr>
        			<td width="30">&nbsp;</td>
        			<td>&nbsp;</td>
        			<td width="30">&nbsp;</td>
      			</tr>
      			<tr>
        			<td width="30">&nbsp;</td>
        			<td height="60">Une enquête a été réalisée, voici les réponses saisies : </td>
        			<td width="30">&nbsp;</td>
      			</tr>
      			<tr>
        			<td width="30">&nbsp;</td>
        			<td>
                    	<table width="100%" border="0" cellspacing="0" cellpadding="5">
                          <tr>
                            <td>Type d'enquêteur : </td>
                            <td>
                                @if (NULL != $type || $type != "") {{ $type }} @else - @endif
                            </td>
                          </tr>
                          <tr>
                            <td>ID : </td>
                            <td>
                                @if (NULL != $data->idProspect || $data->idProspect != "") {{ $data->idProspect }} 
                                @else - @endif
                            </td>
                          </tr>
                          @if ($type == "Prospect")
                          <tr>
                            <td>Village enquêté : </td>
                            <td>
                                @if (NULL != $data->village || $data->village != "") {{ $data->village }} 
                                @else - @endif
                            </td>
                          </tr>
                          @endif
                          <tr>
                            <td>Géolocalisation : </td>
                            <td> 
                                Longitude : @if (NULL != $data->longitude || $data->longitude != "") {{ $data->longitude }} @else - @endif // 
                                Latitude : @if (NULL != $data->latitude || $data->latitude != "") {{ $data->latitude }} @else - @endif
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" align="center" height="60"><b>Contact</b></td>
                          </tr>
                          <tr>
                            <td>Prénom : </td>
                            <td>
                                @if (NULL != $data->clientFirstname || $data->clientFirstname != "") {{ $data->clientFirstname }} @else - @endif
                            </td>
                        </tr>
                          <tr>
                            <td>Nom : </td>
                            <td>
                                @if (NULL != $data->clientLastname || $data->clientLastname != "") {{ $data->clientLastname }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Situation : </td>
                            <td>
                                @if (NULL != $data->clientSituation || $data->clientSituation != "") {{ $data->clientSituation }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Téléphone : </td>
                            <td>
                                @if (NULL != $data->clientTel || $data->clientTel != "") {{ $data->clientTel }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Activité : </td>
                            <td>
                                @if (NULL != $data->clientJob || $data->clientJob != "") {{ $data->clientJob }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Type de foyer : </td>
                            <td>
                                @if (NULL != $data->clientFoyer || $data->clientFoyer != "") {{ $data->clientFoyer }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" height="60"><b>Equipements disponibles / souhaités</b></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table width="100%">
                                    
                                    <tr>
                                        <td width="400"><b>Produits</b></td>
                                        <td width="100"><b>Disponibles</b></td>
                                        <td width="100"><b>Souhaités</b></td>
                                    </tr>   
                                    <tr>
                                        <td>Lampe pétrole : </td>
                                        <td>
                                            @if (NULL != $data->dispo_lampe || $data->dispo_lampe != "") {{ $data->dispo_lampe }} @else 0 @endif
                                        </td>
                                        <td>-</td>
                                    </tr>       
                                    <tr>
                                        <td>Torche électrique : </td>
                                        <td>
                                            @if (NULL != $data->dispo_torche || $data->dispo_torche != "") {{ $data->dispo_lampe }} @else 0 @endif
                                        </td>
                                        <td>-</td>
                                    </tr>                          
                                    <tr>
                                        <td>Bougie : </td>
                                        <td>
                                            @if (NULL != $data->dispo_bougie || $data->dispo_bougie != "") {{ $data->dispo_bougie }} @else 0 @endif
                                        </td>
                                        <td>-</td>
                                    </tr>              
                                    <tr>
                                        <td>Ampoule : </td>
                                        <td>
                                            @if (NULL != $data->dispo_ampoule || $data->dispo_ampoule != "") {{ $data->dispo_ampoule }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_ampoule || $data->wish_ampoule != "") {{ $data->wish_ampoule }} @else 0 @endif
                                        </td>
                                    </tr>       
                                    <tr>
                                        <td>Ventilateur : </td>
                                        <td>
                                            @if (NULL != $data->dispo_ventilateur || $data->dispo_ventilateur != "") {{ $data->dispo_ventilateur }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_ventilateur || $data->wish_ventilateur != "") {{ $data->wish_ventilateur }} @else 0 @endif
                                        </td>
                                    </tr>       
                                    <tr>
                                        <td>Téléphone : </td>
                                        <td>
                                            @if (NULL != $data->dispo_tel || $data->dispo_tel != "") {{ $data->dispo_tel }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_tel || $data->wish_tel != "") {{ $data->wish_tel }} @else 0 @endif
                                        </td>
                                    </tr>       
                                    <tr>
                                        <td>Climatisation : </td>
                                        <td>
                                            @if (NULL != $data->dispo_clim || $data->dispo_clim != "") {{ $data->dispo_clim }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_clim || $data->wish_clim != "") {{ $data->wish_clim }} @else 0 @endif
                                        </td>
                                    </tr>  
                                    <tr>
                                        <td>Radio : </td>
                                        <td>
                                            @if (NULL != $data->dispo_radio || $data->dispo_radio != "") {{ $data->dispo_radio }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_radio || $data->wish_radio != "") {{ $data->wish_radio }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Machine à laver : </td>
                                        <td>
                                            @if (NULL != $data->dispo_machine_laver || $data->dispo_machine_laver != "") {{ $data->dispo_machine_laver }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_machine_laver || $data->wish_machine_laver != "") {{ $data->wish_machine_laver }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Réfrigérateur : </td>
                                        <td>
                                            @if (NULL != $data->dispo_frigo || $data->dispo_frigo != "") {{ $data->dispo_frigo }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_frigo || $data->wish_frigo != "") {{ $data->wish_frigo }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Congélateur : </td>
                                        <td>
                                            @if (NULL != $data->dispo_congelateur || $data->dispo_congelateur != "") {{ $data->dispo_congelateur }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_congelateur || $data->wish_congelateur != "") {{ $data->wish_congelateur }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TV : </td>
                                        <td>
                                            @if (NULL != $data->dispo_tv || $data->dispo_tv != "") {{ $data->dispo_tv }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_tv || $data->wish_tv != "") {{ $data->wish_tv }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lecteur DVD : </td>
                                        <td>
                                            @if (NULL != $data->dispo_dvd || $data->dispo_dvd != "") {{ $data->dispo_dvd }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_dvd || $data->wish_dvd != "") {{ $data->wish_dvd }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tondeuse électrique : </td>
                                        <td>
                                            @if (NULL != $data->dispo_tondeuse || $data->dispo_tondeuse != "") {{ $data->dispo_tondeuse }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_tondeuse || $data->wish_tondeuse != "") {{ $data->wish_tondeuse }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Machine à broder : </td>
                                        <td>
                                            @if (NULL != $data->dispo_machine_broder || $data->dispo_machine_broder != "") {{ $data->dispo_machine_broder }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_machine_broder || $data->wish_machine_broder != "") {{ $data->wish_machine_broder }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Machine à pleinte : </td>
                                        <td>
                                            @if (NULL != $data->dispo_machine_pleinte || $data->dispo_machine_pleinte != "") {{ $data->dispo_machine_pleinte }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_machine_pleinte || $data->wish_machine_pleinte != "") {{ $data->wish_machine_pleinte }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Machine à coudre : </td>
                                        <td>
                                            @if (NULL != $data->dispo_machine_coudre || $data->dispo_machine_coudre != "") {{ $data->dispo_machine_coudre }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_machine_coudre || $data->wish_machine_coudre != "") {{ $data->wish_machine_coudre }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Scie circulaire électrique : </td>
                                        <td>
                                            @if (NULL != $data->dispo_scie_circulaire || $data->dispo_scie_circulaire != "") {{ $data->dispo_scie_circulaire }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_scie_circulaire || $data->wish_scie_circulaire != "") {{ $data->wish_scie_circulaire }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Scie sauteuse electrique : </td>
                                        <td>
                                            @if (NULL != $data->dispo_scie_sauteuse || $data->dispo_scie_sauteuse != "") {{ $data->dispo_scie_sauteuse }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_scie_sauteuse || $data->wish_scie_sauteuse != "") {{ $data->wish_scie_sauteuse }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Toupie : </td>
                                        <td>
                                            @if (NULL != $data->dispo_toupie || $data->dispo_toupie != "") {{ $data->dispo_toupie }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_toupie || $data->wish_toupie != "") {{ $data->wish_toupie }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Raboteuse : </td>
                                        <td>
                                            @if (NULL != $data->dispo_raboteuse || $data->dispo_raboteuse != "") {{ $data->dispo_raboteuse }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_raboteuse || $data->wish_raboteuse != "") {{ $data->wish_raboteuse }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fraise électrique : </td>
                                        <td>
                                            @if (NULL != $data->dispo_fraise || $data->dispo_fraise != "") {{ $data->dispo_fraise }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_fraise || $data->wish_fraise != "") {{ $data->wish_fraise }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Moulin électrique : </td>
                                        <td>
                                            @if (NULL != $data->dispo_moulin || $data->dispo_moulin != "") {{ $data->dispo_moulin }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_moulin || $data->wish_moulin != "") {{ $data->wish_moulin }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Arc à souder : </td>
                                        <td>
                                            @if (NULL != $data->dispo_arc_souder || $data->dispo_arc_souder != "") {{ $data->dispo_arc_souder }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_arc_souder || $data->wish_arc_souder != "") {{ $data->wish_arc_souder }} @else 0 @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ponceuse : </td>
                                        <td>
                                            @if (NULL != $data->dispo_ponceuse || $data->dispo_ponceuse != "") {{ $data->dispo_ponceuse }} @else 0 @endif
                                        </td>
                                        <td>
                                            @if (NULL != $data->wish_ponceuse || $data->wish_ponceuse != "") {{ $data->wish_ponceuse }} @else 0 @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            
                        </tr>
                        <tr>
                            <td align="center" colspan="2" height="60"><b>Production énergie</b></td>
                        </tr>
                        <tr>
                            <td>Kit solaire : </td>
                            <td>
                                @if (NULL != $data->clientKit || $data->clientKit != "") {{ $data->clientKit }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Puissance kit solaire : </td>
                            <td>
                                @if (NULL != $data->clientKitP || $data->clientKitP != "") {{ $data->clientKitP }} W @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Compagnie électrique : </td>
                            <td>
                                @if (NULL != $data->clientCeet || $data->clientCeet != "") {{ $data->clientCeet }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Abonnement : </td>
                            <td>
                                @if (NULL != $data->clientCeetTranche || $data->clientCeetTranche != "") {{ $data->clientCeetTranche }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Groupe electrogène : </td>
                            <td>
                                @if (NULL != $data->clientGE || $data->clientGE != "") {{ $data->clientGE }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Puissance groupe electrogène : </td>
                            <td>
                                @if (NULL != $data->clientGEP || $data->clientGEP != "") {{ $data->clientGEP }} W @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Mini-réseau : </td>
                            <td>
                                @if (NULL != $data->clientReseau || $data->clientReseau != "") {{ $data->clientReseau }} @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Puissance mini-réseau : </td>
                            <td>
                                @if (NULL != $data->clientReseauP || $data->clientReseauP != "") {{ $data->clientReseauP }} W  @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2" height="60"><b>Autres équipements</b></td>
                        </tr>
                        <tr>
                            <td>Opérateur 1 : </td>
                            <td>
                                @if (NULL != $data->telephoneOperator || $data->telephoneOperator != "") {{ $data->telephoneOperator }}  @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Opérateur 2 : </td>
                            <td>
                                @if (NULL != $data->telephoneOperator2 || $data->telephoneOperator2 != "") {{ $data->telephoneOperator2 }}  @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Coût recharge tél./sem. : </td>
                            <td>
                                @if (NULL != $data->telephoneCost || $data->telephoneCost != "") {{ $data->telephoneCost }}  @else - @endif
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2" height="60"><b>Résultats</b></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">Actuellement vous consommez <b>{{$dispoKw}} Wh/jour</b>. Il faudra <b>{{$wishKw}} Wh/jour de plus</b> pour couvrir les besoins en énergie des équipements souhaités.</td>
                        </tr>
                        
                    </table>
                </td>
                <td width="30">&nbsp;</td>
            </tr>             
            <tr>
                <td width="30">&nbsp;</td>
                <td height="30">&nbsp;</td>
                <td width="30">&nbsp;</td>
            </tr>
        </table>
    </td>
    
</table>

</body>
</html>

</tr>
