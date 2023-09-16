# Teste_PHP_2022_IEFP_RECUP
 
É necessário criar um sistema para gerir uma competição de profissões para tal é necessário
gerir as inscrições, provas e resultados, o sistema pedido tem os seguintes requisitos:
1. Registar Prova
2. Editar Prova
3. Registar Critérios
4. Listar Critérios
5. Remover Critérios
6. Editar Critérios
7. Registar Concorrente
8. Registar Inscrição de Concorrente
9. Registar Resultados
10. Atribuir pontuação ao Concorrente
11. Listagem de classificação ordenada
12. Informação detalhada da classificação do concorrente

    
NOTAS:
- A base de dados tem o nome “competicao”
- No ponto 3:
  - os critérios só podem ser registados após existir uma prova
  - Não existe limite para registo de critérios
- No ponto 4:
  - A listagem deve conter dois botões para remover e editar os critérios
  - A edição é feita num formulário dentro de um modal
- No ponto 7:
  - Só podem ser registados concorrentes com idade inferior ou igual a 25 anos
- No ponto 8:
  - Só podem ser inscritos concorrentes com idade igual ou inferior à idade limite da prova
- No ponto 9:
  - O registo é automático, não havendo formulário para o efeito
  - Este registo é efetuado após a inscrição do concorrente numa prova
  - Todos os critérios de avaliação da prova iniciam com a pontuação a 0
- No ponto 10:
  - A atribuição de pontos deverá ser efetuada por cada critério.
  - Deve escolher um critério e registar a sua pontuação
  - O Concorrente é escolhido através de uma select box
  - A pontuação atribuída não pode ser inferior à pontuação mínima do critério
  - A pontuação atribuída não pode ser superior à pontuação máxima do critério
  - Sempre que é atribuída uma pontuação o campo de data e hora deve ser atualizado
- No ponto 11:
  - A classificação é ordenada da maior pontuação para a menor
  - Deverá ser escolhida a prova para depois listar a classificação dessa prova
- No ponto 12:
  - Deve ser disponibilizado um botão na tabela de classificação com a descrição “info”
  - Abrir em modal todos os critérios avaliados com a pontuação do respetivo concorrente
  - Deve mostrar no modal o nome do concorrente, o total de pontos e o nome da prova
