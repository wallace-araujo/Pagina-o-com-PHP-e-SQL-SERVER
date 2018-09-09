PHP

<html>
<head>
<title>Modelo de Pagina  PHP & SQL Server</title>
</head>
<body>
<?php
	ini_set('display_errors', 1);
	error_reporting(~0);



    // Realizando Conexão  utilizando sqlsrv
	$serverName = "localhost";
	$userName = "USUARIO BD";
	$userPassword = 'SENHA DO BD';
	$dbName = "NOME DO BANCO";

	$connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    // Fim Realizando Conexão  utilizando sqlsrv

    
	$sql = "SELECT * FROM TabelaCadastro";

	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$query = sqlsrv_query( $conn, $sql , $params, $options );

	$num_rows = sqlsrv_num_rows($query);

	$qtd_registro = 5;   // quantidade de registro por pagina
	$page  = 1;
	
	if(isset($_GET["Page"]))
	{
		$page = $_GET["Page"];
	}

	$prev_page = $page-1;
	$next_page = $page+1;

	$row_start = (($qtd_registro*$page)-$qtd_registro);
	if($num_rows<=$qtd_registro)
	{
		$num_pages =1;
	}
	else if(($num_rows % $qtd_registro)==0)
	{
		$num_pages =($num_rows/$qtd_registro) ;
	}
	else
	{
		$num_pages =($num_rows/$qtd_registro)+1;
		$num_pages = (int)$num_pages;
	}
	$row_end = $qtd_registro * $page;
	if($row_end > $num_rows)
	{
		$row_end = $num_rows;
	}


	$sql = " SELECT c.* FROM (
		SELECT ROW_NUMBER() OVER(ORDER BY id) AS RowID,*  FROM TabelaCadastro
		) AS c 
	WHERE c.RowID > $row_start AND c.RowID <= $row_end
	";
	$query = sqlsrv_query( $conn, $sql );

?>
<table width="600" border="1">
  <tr>
    <th width="91"> <div align="center">ID </div></th>
    <th width="98"> <div align="center">Nome </div></th>
    <th width="198"> <div align="center">Email </div></th>
    <th width="97"> <div align="center">Tel </div></th>
    <th width="59"> <div align="center">Sexo </div></th>
    <th width="71"> <div align="center">Estado </div></th>
  </tr>
<?php
while($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
?>
  <tr>
    <td><div align="center"><?php echo $result["id"];?></div></td>
    <td><?php echo $result["nome"];?></td>
    <td><?php echo $result["email"];?></td>
    <td><div align="center"><?php echo $result["tel"];?></div></td>
    <td align="right"><?php echo $result["sexo"];?></td>
    <td align="right"><?php echo $result["estado"];?></td>
  </tr>
<?php
}
?>
</table>
<br>
Total de Registros: <?php echo $num_rows;?> Numero de Paginas: <?php echo $num_pages;?>
<br>
<?php
if($prev_page)
{
	echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page'><< Voltar</a> ";
}

for($i=1; $i<=$num_pages; $i++){
	if($i != $page)
	{
		echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a> ]";
	}
	else
	{
		echo "<b> $i </b>";
	}
}
if($page!=$num_pages)
{
	echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$next_page'>Proximo >></a> ";
}
sqlsrv_close($conn);
?>
</body>
</html>
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
49
50
51
52
53
54
55
56
57
58
59
60
61
62
63
64
65
66
67
68
69
70
71
72
73
74
75
76
77
78
79
80
81
82
83
84
85
86
87
88
89
90
91
92
93
94
95
96
97
98
99
100
101
102
103
104
105
106
107
108
109
110
111
112
113
114
115
116
117
118
119
120
121
122
123
124
125
126
<html>
<head>
<title>Modelo de Pagina  PHP & SQL Server</title>
</head>
<body>
<?php
	ini_set('display_errors', 1);
	error_reporting(~0);
 
 
 
    // Realizando Conexão  utilizando sqlsrv
	$serverName = "localhost";
	$userName = "USUARIO BD";
	$userPassword = 'SENHA DO BD';
	$dbName = "NOME DO BANCO";
 
	$connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
 
	if( $conn === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    // Fim Realizando Conexão  utilizando sqlsrv
 
    
	$sql = "SELECT * FROM TabelaCadastro";
 
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$query = sqlsrv_query( $conn, $sql , $params, $options );
 
	$num_rows = sqlsrv_num_rows($query);
 
	$qtd_registro = 5;   // quantidade de registro por pagina
	$page  = 1;
	
	if(isset($_GET["Page"]))
	{
		$page = $_GET["Page"];
	}
 
	$prev_page = $page-1;
	$next_page = $page+1;
 
	$row_start = (($qtd_registro*$page)-$qtd_registro);
	if($num_rows<=$qtd_registro)
	{
		$num_pages =1;
	}
	else if(($num_rows % $qtd_registro)==0)
	{
		$num_pages =($num_rows/$qtd_registro) ;
	}
	else
	{
		$num_pages =($num_rows/$qtd_registro)+1;
		$num_pages = (int)$num_pages;
	}
	$row_end = $qtd_registro * $page;
	if($row_end > $num_rows)
	{
		$row_end = $num_rows;
	}
 
 
	$sql = " SELECT c.* FROM (
		SELECT ROW_NUMBER() OVER(ORDER BY id) AS RowID,*  FROM TabelaCadastro
		) AS c 
	WHERE c.RowID > $row_start AND c.RowID <= $row_end
	";
	$query = sqlsrv_query( $conn, $sql );
 
?>
<table width="600" border="1">
  <tr>
    <th width="91"> <div align="center">ID </div></th>
    <th width="98"> <div align="center">Nome </div></th>
    <th width="198"> <div align="center">Email </div></th>
    <th width="97"> <div align="center">Tel </div></th>
    <th width="59"> <div align="center">Sexo </div></th>
    <th width="71"> <div align="center">Estado </div></th>
  </tr>
<?php
while($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
?>
  <tr>
    <td><div align="center"><?php echo $result["id"];?></div></td>
    <td><?php echo $result["nome"];?></td>
    <td><?php echo $result["email"];?></td>
    <td><div align="center"><?php echo $result["tel"];?></div></td>
    <td align="right"><?php echo $result["sexo"];?></td>
    <td align="right"><?php echo $result["estado"];?></td>
  </tr>
<?php
}
?>
</table>
<br>
Total de Registros: <?php echo $num_rows;?> Numero de Paginas: <?php echo $num_pages;?>
<br>
<?php
if($prev_page)
{
	echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page'><< Voltar</a> ";
}
 
for($i=1; $i<=$num_pages; $i++){
	if($i != $page)
	{
		echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a> ]";
	}
	else
	{
		echo "<b> $i </b>";
	}
}
if($page!=$num_pages)
{
	echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$next_page'>Proximo >></a> ";
}
sqlsrv_close($conn);
?>
</body>
</html>