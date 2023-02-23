import React from 'react'
import OrderCard from './components/OrderCard'

function App({fullName}) {
  return (
	<div><OrderCard fullName={fullName}/></div>
  )
}

export default App