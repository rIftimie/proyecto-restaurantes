import React, { useEffect, useState } from "react";

import { getProducts } from "../../helpers/products";
import ProductsButtons from './ProductsButtons';
   
const Products = ({ idres , idtable , orderProducts , setOrderProducts, setShow}) => {
  const [prods, setProds] = useState([])
  useEffect(() => {
    getProds(idres);
  }, [])
  

  const getProds =  async (el)=>{
    const prt=await getProducts(el);
    setProds(prt);
    setShow(true);
  }

  return (
          <>
            {
              prods.map((prod)=>(
                <> 
                  { prod.stock && !prod.hidden && <div key={prod.id}>
                                                    <img src={prod.product.img} alt={prod.product.name} width={200}/>
                                                    <h5> {prod.product.name} </h5>
                                                    <h6> {prod.product.description} </h6>
                                                    <h3> {prod.product.price}€ </h3>
                                                    {prod.product.allergens && <h6>Alérgenos: {prod.product.allergens.map((all)=>(all+' '))}</h6>}
                                                    <ProductsButtons idres={ idres } idtable={ idtable } orderProducts={ orderProducts }  setOrderProducts={ setOrderProducts } idprod={prod.id} />
                                                  </div>}
                </>
              ))
            }
          </>
  );
}

export default Products;
