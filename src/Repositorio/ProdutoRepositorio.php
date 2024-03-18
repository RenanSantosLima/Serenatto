<?php 

    class ProdutoRepositorio {

        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        private function formarObjeto($dados){
            return new Produto($dados['id'],
                $dados['tipo'],
                $dados['nome'],
                $dados['descricao'],
                $dados['preco'],
                $dados['imagem']);
        }

        public function opcoesCafe(): array {
            $sql1 = "Select * from produtos Where tipo = 'Café' Order by preco;";
            $stmt = $this->pdo->query($sql1);
            $produtosCafe = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $dadosCafe = array_map(function ($cafe) {
                return $this->formarObjeto($cafe);
            }, $produtosCafe);

            return $dadosCafe;
        }

        public function opcoesAlmoco(): array {
            $sql2 = "Select * from produtos Where tipo = 'Almoço' Order by preco;";
            $stmt = $this->pdo->query($sql2);
            $produtosAlmoco = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $dadosAlmoco = array_map(function ($almoco) {
                return new Produto($almoco['id'], $almoco['tipo'], $almoco['nome'], 
                $almoco['descricao'], $almoco['preco'], $almoco['imagem']);
            }, $produtosAlmoco);

            return $dadosAlmoco;
        }

        public function buscarTodos() {
            $sql = "Select * From produtos Order by preco;";
            $stmt = $this->pdo->query($sql);
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $todosOsDados = array_map(function ($produto) {
                return $this->formarObjeto($produto);
            }, $dados);

            return $todosOsDados;
        }

        public function deletar(int $id) {
            $sql = "Delete From produtos Where id = ?;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
        }

        public function salvar(Produto $produto) {
            $sql = "Insert Into produtos (tipo, nome, descricao, imagem, preco) 
            Values (:tipo, :nome, :descricao, :imagem, :preco);";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":tipo", $produto->recuperarTipo());
            $stmt->bindValue(":nome", $produto->recuperarNome());
            $stmt->bindValue(":descricao", $produto->recuperarDescricao());
            $stmt->bindValue(":imagem", $produto->recuperarImagem());
            $stmt->bindValue(":preco", $produto->recuperarPreco());
            $stmt->execute();
        }

        public function buscar(int $id) {
            $sql = "Select * from produtos Where id = :id;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->formarObjeto($dados);
        }

        public function atualizar(Produto $produto) {
            $sql = "Update produtos Set tipo = :tipo, nome = :nome, descricao = :descricao,
            preco = :preco Where id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":tipo", $produto->recuperarTipo());
            $stmt->bindValue(":nome", $produto->recuperarNome());
            $stmt->bindValue(":descricao", $produto->recuperarDescricao());
            $stmt->bindValue(":preco", $produto->recuperarPreco());
            $stmt->bindValue(":id", $produto->recuperarId());
            $stmt->execute();

            if($produto->recuperarImagem() !== 'logo-serenatto.png'){
            
                $this->atualizarFoto($produto);
            }

        }

        private function atualizarFoto(Produto $produto) {
            $sql = "Update produtos Set imagem = :imagem Where id = :id;";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":imagem", $produto->recuperarImagem());
            $statement->bindValue(":id", $produto->recuperarId());
            $statement->execute();
        }
    }

?>