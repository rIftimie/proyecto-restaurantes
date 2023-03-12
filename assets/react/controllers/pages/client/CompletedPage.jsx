import React from 'react'
import ProductCompleted from "./ProductCompleted";

const Completed = ({ order }) => {

    const productos = [
      {
        id: 1,
        nombre: 'Nachos con queso',
        img: 'https://imgpile.com/images/dewPUW.jpg',
        precio: 5,
        extras: [
          {
            nombre: 'Extra limón',
            precio: 0.5
          },
        ]
      },
      {
        id: 2,
        nombre: 'Nachos con guacamole',
        img: 'https://imgpile.com/images/dewPUW.jpg',
        precio: 5.50,
        extras: [
          {
            nombre: 'Extra limón',
            precio: 0.5
          },
          {
            nombre: 'Extra Picante',
            precio: 0.5
          }
        ]
      }
    ]

    return (
        <div style={{width: "450px"}} className="m-auto mt-5 p-1 border rounded-2">
          <div className='row m-0 p-1'>
            <div className='col-12 text-center'>
              <h1>Número de pedido</h1>
            </div>
            <h1 className='col-12 text-center my-3'>69</h1>
            <h5 className="text-center">Pedido hecho</h5>
            {
              productos.map(producto => (
                  <ProductCompleted key={producto.id} data={producto}></ProductCompleted>
              ))
            }
          </div>
        </div>
    )
}

export default Completed