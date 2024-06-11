import mysql.connector
from mysql.connector import Error

def leer_tabla_clientes():
    try:
        # Conectar a la base de datos
        connection = mysql.connector.connect(
            host="db-2024.mysql.database.azure.com",
            user="jim",
            password="2839064Void",
            database="db-ticket"
        )

        if connection.is_connected():
            cursor = connection.cursor()
            # Consulta para leer todos los datos de la tabla clientes
            query = "SELECT * FROM clientes"
            cursor.execute(query)
            results = cursor.fetchall()

            # Imprimir los resultados
            for row in results:
                print(row)

    except Error as e:
        print("Error al conectar a la base de datos:", e)

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

if __name__ == "__main__":
    leer_tabla_clientes()
