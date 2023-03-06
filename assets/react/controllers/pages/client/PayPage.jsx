import React from 'react'
import Subtotal from '../../components/subtotal/Subtotal'
import Productos from '../../components/products'

const PayPage = ({ stripeKey }) => {
  return (
    <>
      <div> <Productos /> </div>
      <div class='position-absolute bottom-0 m-5'> <Subtotal stripeKey={ stripeKey }/> </div>
    </>
  )
}

export default PayPage