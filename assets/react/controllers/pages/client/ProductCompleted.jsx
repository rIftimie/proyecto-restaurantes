import React, {useEffect, useState} from 'react'
import uniqid from 'uniqid'

const ProductCompleted = ({data}) => {

  const [subtotal, setSubtotal] = useState(0);

  useEffect(() => {
    const precio = data.extras.reduce((acc, {precio}) => acc+precio, 0);
    setSubtotal(precio);
    return () => {

    };
  }, []);

  return (
      <div key={data.id}>
        <div className="d-flex align-items-center">
          <h4>{data.name}</h4>
          <img width="50px" height="50px" src={data.img} className="rounded-circle ms-auto" alt=""/>
        </div>

        <div className='d-flex my-1' style={{alignItems: "baseline", borderBottom: "1px solid #fafad2"}}>
          <div className='me-auto'>SubTotal</div>
          <div className='ms-auto'>{subtotal + data.price} €</div>
        </div>
        <br/>
      </div>
  )
}

export default ProductCompleted