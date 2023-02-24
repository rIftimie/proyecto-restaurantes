import React from 'react'
import OrderCard from './components/OrderCard'
import Waiter from './pages/waiter/WaiterPage'
import Kitchen from './pages/kitchen/KitchenPage'
function App({fullName}) {
  return (
	<div><OrderCard fullName={fullName}/>
   
    
  </div>

  )
}

export default App