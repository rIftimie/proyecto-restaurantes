import React from 'react'
import OrderCard from './components/OrderCard'

<<<<<<< HEAD
function App() {
	return <div className="container-fluid bg-primary">App</div>;
=======
function App({fullName}) {
  return (
	<div><OrderCard fullName={fullName}/></div>
  )
>>>>>>> 2-waiter
}

export default App