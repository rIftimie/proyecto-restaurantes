import React, { useEffect, useState } from "react";
import PropTypes from 'prop-types';

import AddButton from "./AddButton";
import DeleteButton from "./DeleteButton";
import { getProducts } from "../../helpers/products";
   
const Products = ({ idres , idtable , orderProducts , setOrderProducts}) => {
  const [prods, setProds] = useState([])
  useEffect(() => {
    getProds(idres);
  }, [])
  

  const getProds =  async (el)=>{
    const prt=await getProducts(el);
    setProds(prt);
  }
  console.log(prods);
  // const prods = Array.from({ length: 4 }, (_, index) => (
  //   <div key={index}>
  //     <img src='' alt="Nachos con queso" width={200}/>
  //     <h5> {texto} </h5>
  //     <h6> {descripcion} </h6>
  //     <AddButton/>
  //     <DeleteButton/>
  //   </div>
  // ));

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
                                                  </div>}
                </>
              ))
            }
          </>
  );
}

export default Products;
