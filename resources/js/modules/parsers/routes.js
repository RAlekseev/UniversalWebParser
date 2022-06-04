import Index from './components/Index'
import Show from './components/Show'
import ResultShow from './components/ResultShow'

export default [
    {
        path: 'parsers',
        component: Index,
        name: 'parsersIndex',
    },
    {
        path: 'parsers/show/:id',
        component: Show,
        name: 'parserShow',
    },
    {
        path: 'parsersResult/show/:id',
        component: ResultShow,
        name: 'parserResultShow',
    },
]
