<?php

class Dono {

    private $id;
    private $nome;
    private $fone;

    public function __construct($nome, $fone, $id = null) {

        $this->nome = $nome;
        $this->fone = $fone;
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getFone() {
        return $this->fone;
    }
}
class Animal {

    private $id;
    private $nome_animal;
    private $especie;

    public function __construct($nome_animal, $especie, $id = null) {
        $this->nome_animal = $nome_animal;
        $this->especie = $especie;
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getNomeAnimal() {
        return $this->nome_animal;
    }

    public function getEspecie() {
        return $this->especie;
    }
}

$host = "localhost";
$porta = "5432";
$database = "pet";
$usuario = "postgres";
$senha = "postgres";

$dsn = "pgsql:host=$host;port=$porta;dbname=$database";

$conexao = new PDO($dsn, $usuario, $senha);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['salvar_dono'])) {

        $dono = new Dono(
            $_POST['nome'],
            $_POST['fone']
        );

        $sql = "INSERT INTO dono(nome, fone)
                VALUES (?, ?)";

        $conexao->prepare($sql)->execute([

            $dono->getNome(),
            $dono->getFone()

        ]);
    }

    if (isset($_POST['salvar_animal'])) {

        $animal = new Animal(
            $_POST['nome_animal'],
            $_POST['especie']
        );

        $sql = "INSERT INTO animal(nome_animal, especie)
                VALUES (?, ?)";

        $conexao->prepare($sql)->execute([

            $animal->getNomeAnimal(),
            $animal->getEspecie()

        ]);
    }

    header("Location: index.php");
    exit;
}

$donos = [];

foreach ($conexao->query("SELECT * FROM dono") as $row) {

    $donos[] = new Dono(

        $row['nome'],
        $row['fone'],
        $row['id']

    );
}

$animais = [];

foreach ($conexao->query("SELECT * FROM animal") as $row) {

    $animais[] = new Animal(

        $row['nome_animal'],
        $row['especie'],
        $row['id']

    );
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Shop Univates</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        section {
            background: white;
            padding: 20px;
            width: 320px;
            border: 1px solid #ccc;
        }

        h2 {
            margin-top: 0;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #ddd;
            border: 1px solid #999;
            cursor: pointer;
        }

        button:hover {
            background: #ccc;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #eaeaea;
        }

    </style>

</head>

<body>

    <h1>Sistema Pet Shop</h1>

    <div class="container">

        <section>

            <h2>Cadastro de Dono</h2>

            <form method="post">

                <input 
                type="text"
                name="nome"
                placeholder="Nome do Dono"
                required>

                <input 
                type="text"
                name="fone"
                placeholder="Telefone"
                required>

                <button 
                type="submit"
                name="salvar_dono">
                    Salvar Dono
                </button>

            </form>

            <table>

                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                </tr>

                <?php foreach ($donos as $d): ?>

                <tr>
                    <td><?= $d->getId() ?></td>
                    <td><?= $d->getNome() ?></td>
                    <td><?= $d->getFone() ?></td>
                </tr>

                <?php endforeach; ?>

            </table>

        </section>

        <section>

            <h2>Cadastro de Animal</h2>

            <form method="post">

                <input 
                type="text"
                name="nome_animal"
                placeholder="Nome do Animal"
                required>

                <input 
                type="text"
                name="especie"
                placeholder="Espécie"
                required>

                <button 
                type="submit"
                name="salvar_animal">
                    Salvar Animal
                </button>

            </form>

            <table>

                <tr>
                    <th>ID</th>
                    <th>Animal</th>
                    <th>Espécie</th>
                </tr>

<?php foreach ($animais as $a): ?>

<tr>
<td><?= $a->getId() ?></td>
<td><?= $a->getNomeAnimal() ?></td>
<td><?= $a->getEspecie() ?></td>
</tr>

<?php endforeach; ?>

</table>

</section>

</div>

</body>
</html>
