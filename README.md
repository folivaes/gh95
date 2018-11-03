# gh95
Importação e procura na base em elasticsearch

0) Zerar base da dados do elasticsearch:
- através da api (extensão do chrome ou kibana):
    DELETE /gh95/

1) configurar esquema/algoritimo do elasticsearch:
- através da api (extensão do chrome ou kibana):
    executar o esquema através do schema-XXXXXX.json

2) Importar os dados:
# php import.php

3) Rodar o search para o esquema/algoritimo atual:
# php search.php > resultado-nome-esquema.txt

4) comparar os resultados com treceval8.1.exe
# treceval8.1.exe -c -o qrels_GH05.txt resultado-nome-esquema.txt > resultado-nome-esquema.txt
