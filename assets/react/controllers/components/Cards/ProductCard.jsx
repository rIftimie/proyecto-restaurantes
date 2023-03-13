import React, {useEffect, useState} from 'react'

const ProductCard = ({ data }) => {

  return (
      <div key={data.id}>
        <div className="d-flex align-items-center">
          <h4>{data.name}</h4>
          <img width="50px" height="50px" src={data.img} className="rounded-circle ms-auto" alt=""/>
        </div>

        <div className='d-flex my-1' style={{alignItems: "baseline", borderBottom: "1px solid #fafad2"}}>
          <div className='me-auto'>{data.price}€ x{data.quantity}</div>
          <div className='ms-auto'>{data.quantity*data.price}€</div>
        </div>
        <br/>

      </div>
  )
}

export default ProductCard