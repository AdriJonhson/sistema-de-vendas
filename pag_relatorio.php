<?php 
include("ezpdf/Cezpdf.php");
include('php/Vendas.php');

$pdf = new Cezpdf();
$pdf->selectFont('ezpdf/fonts/Helvetica.afm');

$qtdTotal = contarTotal();
$qtdMes = contarTotalMes();
$nomeMovelMes = verMovelMes();
$nomeMovelTop = verMovelTop();
$rendaMes = calcularRendaMes();
$rendaTotal = calcularRendaTotal();
$funcionarios = verVendasFuncionarios();

$textoTopico1 = "> Móveis";
$textoQtd = "Quantidade de Móveis vendidos no mês atual: <b>".$qtdMes."</b>";
$textoQtdTotal = "Quantidade de Móveis vendidos até agora:  <b>".$qtdTotal."</b>";
$textoMovelMes = "O Móvel mais vendido nesse mês foi: <b>".$nomeMovelMes."</b>";
$textoMovelTop = "O Móvel mais vendido até agora foi: <b>".$nomeMovelTop."</b>";

$textoTopico2 = "> Renda";
$textoRendaMes ="A renda desse mês foi de <b>R$ ".$rendaMes."</b>";
$textoRendaTotal ="Renda total <b>R$ ".$rendaTotal."</b>";

$textoTopico3 = "> Funcionários";


$pdf -> ezText('Movéis Bem 10', 20, array(justification => 'center', spacing => 2.0));

//Informações referentes aos móveis
$pdf -> ezText(''); 
$pdf -> ezText($textoTopico1, 15);
$pdf -> ezText($textoQtd, 13);
$pdf -> ezText($textoQtdTotal, 13);
$pdf -> ezText($textoMovelMes, 13);
$pdf -> ezText($textoMovelTop, 13);

//Informações referentes a renda
$pdf -> ezText(''); 
$pdf -> ezText($textoTopico2, 15);
$pdf -> ezText($textoRendaMes, 13);
$pdf -> ezText($textoRendaTotal, 13);

//Informações referente aos funcionários
$pdf -> ezText(''); 
$pdf -> ezText($textoTopico3, 15);
$pdf -> ezText('Total de vendas feitas por cada funcionário nesse mês', 12);
$pdf -> ezText(''); 


foreach($funcionarios AS $value){
	$textoFunc = $value['nome'].": ".$value['qtd'];
	$pdf -> ezText($textoFunc, 13);
}

$pdf -> ezStream();
?>