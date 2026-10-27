# Tarea 1 S2 – Colecciones

Ejercicios de arreglos, matrices y registros resueltos en **PHP puro con patrón MVC** (sin framework y sin base de datos).

## Cómo ejecutarlo

Requisito: PHP 8.1 o superior.

```bash
php -S localhost:8000
```

Ejecutar el comando dentro de esta carpeta y abrir <http://localhost:8000>.

## Estructura (un paquete por ejercicio)

```
tarea1-s2/
├── index.php              Menú principal y datos informativos
├── css/estilos.css        Estilos compartidos
├── comun/                 Plantilla común de las vistas
│   ├── cabecera.php           barra superior y menú lateral
│   ├── pie.php                cierre de la página
│   ├── funciones.php          ayudas: e(), dinero(), imprimirVector(), imprimirMatriz()
│   └── ejercicios.php         lista de los 10 ejercicios
└── ejercicioNN/
    ├── EjercicioNNModel.php        M: funciones que trabajan con arreglos/matrices
    ├── EjercicioNNController.php   C: recibe el formulario y llama al modelo
    ├── vista.php                   V: formulario HTML y resultados
    └── Registro.php                M: tipo de dato definido por el usuario (3, 8, 9 y 10)
```

Cada ejercicio se abre por su controlador, por ejemplo `ejercicio01/Ejercicio01Controller.php`.

## Ejercicios

| # | Ejercicio | Tema | Registro |
|---|-----------|------|----------|
| 1 | Cédulas de reprobados en Matemática e Inglés | Arreglos | — |
| 2 | Vector de 20 números aleatorios | Arreglos | — |
| 3 | Búsqueda de empleados por código | Registros | `Empleado` |
| 4 | Operaciones con matrices M x N | Matrices | — |
| 5 | Ventas por artículo y por sucursal | Matrices | — |
| 6 | Ventas de vendedores por año | Matrices | — |
| 7 | Calificaciones de estudiantes | Matrices | — |
| 8 | Grado de eficiencia de operarios | Registros | `Operario` |
| 9 | Inventario de farmacia | Registros | `Medicamento` |
| 10 | Pedidos del restaurante | Registros | `Pedido` |

Los ejercicios 5 a 8 permiten llenar los datos al azar o a mano. Los ejercicios 9 y 10 guardan la lista en la
sesión de PHP (`$_SESSION`) y tienen un botón para cargar datos de ejemplo.
