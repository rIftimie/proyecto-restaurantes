import React, {useEffect, useState} from 'react'
import ProductCard from "./ProductCard";

const CompletedCard = ({ order }) => {

  const [productos, setProductos] = useState([]);

  useEffect(() => {
    setProductos(order.products);
  }, []);

    return (
        <div style={{width: "450px"}} className="my-5 mx-auto p-1 w-75 border rounded-2 bg-success">
          <div className='row m-0 p-1'>
            <div className='col-12 text-center'>
              <h1>Número de pedido</h1>
            </div>
            <h1 className='col-12 text-center my-3'>{ order.id }</h1>
            <h5 className="text-center">Pedido hecho</h5>
            {
              productos.map(producto => (
                  <ProductCard key={producto.id} data={producto}></ProductCard>
              ))
            }
            <div className='col-12 text-center'>
              {productos[0] && <h1>Total: {productos.reduce((acc,obj)=>acc+obj.price,0)}€</h1>}
            </div>
          </div>
        </div>
    )
}

export default CompletedCard