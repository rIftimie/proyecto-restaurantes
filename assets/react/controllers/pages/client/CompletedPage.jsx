import React, {useEffect, useState} from 'react'
import ProductCompleted from "./ProductCompleted";
import {getOrderById} from "../../helpers/orders";

const Completed = ({ order }) => {

  const [productos, setProductos] = useState([]);

  const fetchGetOrders = async () => {
    const response = await getOrderById(order);
    setProductos(response.products);
  };

  useEffect(() => {
    fetchGetOrders();
  }, []);

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