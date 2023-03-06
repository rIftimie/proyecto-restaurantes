import React from 'react'
import ProductoCompletado from "./ProductoCompletado";

const Pedido = () => {
    const productos = [
        {
            nombre: 'Nachos con queso',
            img: 'wef',
            extras: [
                {
                    nombre: 'Extra limón',
                    precio: 0.5
                },
            ]
        },
        {
            nombre: 'Nachos con guacamole',
            img: 'efw',
            extras: [
                {
                    nombre: 'Extra limón',
                    precio: 0.5
                },
                {
                    nombre: 'Extra Picante',
                    precio: 0.5
                }, {
                    nombre: 'Extra Nachos',
                    precio: 10,
                }
            ]
        }
    ]

    return (
        <div className='container'>
            <div className='row'>
                <div className='col-12'>
                    <h1>Número de pedido</h1>
                </div>
                <div className='col-12'>
                    69
                </div>
            </div>
            <div className='row'>
                <div className='col-12'>
                    <p>Pedido hecho</p>
                    <hr/>
                </div>
                {
                    productos.map(producto => (
                        <ProductoCompletado data={producto}></ProductoCompletado>
                    ))

                    // prueba.map(el => (
                    //     <>
                    //         <div className='col-8'>
                    //             <h4>{el.nombre}</h4>
                    //         </div>
                    //         <div className='col-4'>
                    //             <img src={el.src} alt=""/>
                    //         </div>
                    //         {el.extras[0].nombre && el.extras.map((extra) => (
                    //             <div className='row border-bottom p-1'>
                    //                 <div className='col-10'>{extra.nombre}</div>
                    //                 <div className='col-2'>{extra.precio.toFixed(2)} €</div>
                    //             </div>
                    //         ))}
                    //         <br/>
                    //
                    //     </>
                    // ))
                }
            </div>
            <div className='row'>
                <div></div>
            </div>
        </div>
    )
}

export default Pedido